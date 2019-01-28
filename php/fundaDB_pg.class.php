<?php

/**
 * Postgresql database backend for Fundanemt.
 *
 * @author Ron Cohen <ron@fundanemt.com>
 * @version 2.1
 * @package core
 * @copyright Fundanemt Developers
 *
 * This file is part of Fundanemt CMS.
 *
 * Fundanemt CMS is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Fundanemt CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Fundanemt CMS; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **/

/*==============================================================
INITIATE THE DATABASE CONNECTION
==============================================================*/
register_shutdown_function("closePGConnection");

function closePGConnection() {
    @pg_close();
}

if(!function_exists('pg_connect')) {
    $dlarr = array('postgresql.so','postgresql.dll');
    foreach($dlarr as $dl)
        @dl($dl);
}



// This is required for checking for reserved keywords in dbCreateTable
require_once('./reservedKeywords.inc');

class dataBase {

    var $table, $settings, $dblink;

    /*==============================================================
    CONSTRUCTORS
    ==============================================================*/
    /**
    * @param string Table to use.
    * @access public
    **/
    function dataBase($table='') {
        if($table) {
            $this->table = $table;
        }

        $connectstring="dbname=" . DB . " user=" .DB_USER;

        if(defined('DB_PORT') && constant('DB_PORT') != '') {
            $connectstring=$connectstring." port=" . DB_PORT;
        }

	    if(DB_HOST && DB_HOST != "DB_HOST") {
		    $connectstring=$connectstring." host=" . DB_HOST;
	    }

        if(DB_PASSWD && DB_HOST != "DB_PASSWD") {
            $connectstring=$connectstring." password=" . DB_PASSWD;
        }
        
        $error = defined('DB_MSG_ON_ERROR')?DB_MSG_ON_ERROR:"Couldn't connect to database, please contact administrator";
        $this->dblink = pg_connect($connectstring) or die($error);

        $this->settings['retries'] = 2;
    }//dataBase

     /**
     * Set table to use
     * @param string Table to use.
     * @access public
     **/
    function dbSetTable($table) {
        $this->table = $table;
    }//dbSetTable

    /*==============================================================
    CREATING, DELETING, LISTING, COPYING AND DESCRIBING TABLES
    ==============================================================*/
     /**
     * Create a new table in the active database.
     * <pre>
     * $GLOBALS["D"]->dbSetTable("test"); 
     * if ($GLOBALS["D"]->dbExists()) {
     *   $table = array(
     *     "ID" => "integer",
     *     "TITLE" => "text",
     *   );
     *   $GLOBALS["D"]->dbCreateTable($table);
     * }
     * </pre>
     * @param array
     * @param string Default requeries table set using dbSetTable(), but it can be overriden.
     * @see dbSetTable()
     * @see dbExists()
     * @access public
     **/
    function dbCreateTable($fields,$table=false) {
        $table = ($table)?$table:$this->table;

        // Check if table already exists
        if ($this->dbExists($table)) {
            return false;
        }
        
        foreach ($fields as $name=>$type) {
            if(in_array($name,$GLOBALS['__reservedKeywords'])) die("Sorry, \"$name\" is a reserved keyword, and cannot be used. Please choose another");

            // the column case hack :/
            $name=strtolower($name);

            
            // look for this function further down in the custom functions section...            
            $newtype=pg_change_type($type);
            $layout .= "$name $newtype,";
        }
        $layout = substr($layout,0,-1);
        $res = $this->dbQuery("create table $table (".$layout.")");
        
        return true;
    }//dbCreateTable
    
    /*
     * Select database.
     * @param string Database to select.
     * @access public
     */
    function dbSelectDatabase($database = DB) {
       $connectstring="dbname=" . $database . " user=" .DB_USER;

       if(DB_PORT) {
      $connectstring=$connectstring." port=" . DB_PORT;
       }

       if(DB_HOST && DB_HOST != "DB_HOST") {
      $connectstring=$connectstring." host=" . DB_HOST;
       }

       if(DB_PASSWD && DB_HOST != "DB_PASSWD") {
      $connectstring=$connectstring." password=" . DB_PASSWD;
       }

       $error = defined('DB_MSG_ON_ERROR')?DB_MSG_ON_ERROR:"Couldn't select database, please contact administrator";
       if(!($this->dblink =pg_connect($connectstring)))
      die($error);
    }


    /**
     * Delete table.
     * @param string Override currently selected table.
     * @access public
     **/
    function dbDeleteTable($table=false) {
       $table = $table?$table:$this->table;

       // Check if table exists - otherwise return an error
       if (!$this->dbExists($table)) {
            return false;
       }


       $res = $this->dbQuery("drop table ".$table);
       $this->table = "";

       return true;
    }//dbDeleteTable

    /**
     * List tables in active database.
     * @return array
     * @access public
     **/ 
    function dbListTables() {
       $tables = pg_list_tables($this->dblink);
       $arrayTables = array();
       while($row = pg_fetch_row($tables)) {
      array_push($arrayTables,$row[0]);
       }

       return $arrayTables;
    }//dbListTables

    /**
     * Get table information
     * @param string Override currently selected table.
     * @access public
     **/
    function dbDescribeTable($table=0) {
       $table = ($table)?$table:$this->table;

       // GET oid by doing this psyco query
       $sql="
      SELECT c.oid,
         n.nspname,
         c.relname
            FROM pg_catalog.pg_class c
            LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
            WHERE pg_catalog.pg_table_is_visible(c.oid)
            AND c.relname ~ '^" . strtolower($table) . "$' ORDER BY 2, 3";
       $tempres=$this->dbQuery($sql);
       $oid=$this->dbFetchArray($tempres);
       $oid=$oid[0];

       //get fields
       $tempres=$this->dbQuery("
         SELECT a.attname,
         pg_catalog.format_type(a.atttypid, a.atttypmod),
         a.attnotnull, a.atthasdef, a.attnum
         FROM pg_catalog.pg_attribute a
         WHERE a.attrelid = '$oid' AND a.attnum > 0 AND NOT a.attisdropped
         ORDER BY a.attnum");


       return $tempres;
    }//dbDescribeTable

    /**
     * Copy table OLD over in NEW.
     * @param string Target table
     * @param string Source table.
     * @access public
     **/
    function dbCopyTable($new,$old) {
       // Check if $old table exists - otherwise return an error
       if (!$this->dbExists($old)) {
      return false;
       }

       // Check if $new table exists - otherwise return an error
       if ($this->dbExists($new)) {
      return false;
       }        

       $this->dbQuery("CREATE TABLE $new AS SELECT * FROM $old");

       return true;
    }//dbCopyTable

    /*
     * Rename active or TABLE table to NEW.
     * If your are renaming the working table
     * $this->table is pointed to the new name.
     * @param string Target name of table.
     * @param string Override currently selected table.
     * @access public
     */
    function dbRenameTable($new,$table=0) {
       $old = ($table)?$table:$this->table;

       // Check if $old table exists - otherwise return an error
       if (!$this->dbExists($old)) {
           return false;
       }

       // Check if $new table exists - otherwise return an error
       if ($this->dbExists($new)) {
           return false;
       }        


       $this->dbQuery("ALTER TABLE $old RENAME TO $new");

       if($old == $this->table) {
      $this->table = $new;
       }
       return true;
    }//dbRenameTable

    /*==============================================================
      INSERTATION,UPDATING, DELETING
      ==============================================================*/
    /**
     * Insert new row in table.
     * @param array Row data.
     * @param string Override currently selected table.
     * @access public
     **/
    function dbInsert($array,$table=0) {
       $table = ($table)?$table:$this->table;
       $fields = '';
       $values = '';
       foreach($array as $name=>$value) {
      $fields .= "$name,";
      if($value=="" && is_int($value)==false ) $values .= "NULL,";
      elseif($value===0) $values .= "'0',";
      else $values .= "'$value',";
       }

       $fields = substr($fields,0,-1);
       $values = substr($values,0,-1);
       $res = $this->dbQuery("insert into $table ($fields) values ($values)");
    }//dbInsert

    /**
     * Update row(s) in database.
     * Remember to specify condition array entry to your where clause.
     * <pre>
     * $data = array(
     *   "condition" => "ID=$id",
     *   "TITLE" =>$_REQUEST["title"] 
     * );
     * $GLOBALS["D"]->dbUpdate($data);
     * </pre>
     * To use dbUpdate() to insert new row if needed use:
     * <pre>
     * $data = array(
     *   "condition" => "ID=".(isset($_REQUEST["id"]) ? $_REQUEST["id"] : $GLOBALS["D"]->dbFetchId())
     *   "TITLE" =>$_REQUEST["title"] 
     * );
     * $GLOBALS["D"]->dbUpdate($data);
     * </pre>
     * @param array Row data.
     * @param string Override currently selected table.
     * @access public
     **/
    function dbUpdate($array,$table=0) {
       $table = ($table)?$table:$this->table;
       foreach($array as $field=>$value) {
      if($field != "condition") {
         if ($value=="") $fields .= "$field=NULL,";
         else $fields .= "$field='$value',";
      } else {
         $where = "where $value";
      }
       }

       $fields = substr($fields,0,-1);
       $res = $this->dbQuery("update $table set $fields $where");
    }//dbUpdate

    /**
     * Delete row(s) matching match in currently selected table.
     * <pre>
     * $GLOBALS["D"]->dbSetTable("news_con");
     * $GLOBALS["D"]->dbDelete("ID=1");
     * $GLOBALS["D"]->dbDelete("SECTION=\"Frontpage news\"");
     * </pre>
     * @param string
     * @access public
     **/
    function dbDelete($match) {
       $res = $this->dbQuery("delete from ".$this->table." where $match");
       return $res;
    }//dbDelete

    /*==============================================================
      GET A SINGLE FIELD
      ==============================================================*/
    /**
     * Return field from active table where $id matches $match.
     * @param string Name of field
     * @param int
     * @param string
     * @param string
     * @access public
     **/
    function dbGetField($field,$id,$match,$lang=DEFAULT_LANGUAGE) {

       $res_extra = '';
       if ($lang != "N") {
      $res_extra = "and LANG='$lang'";
       }
       $sqlstring="select ".$field." from ".$this->table." where ".$id."='".$match."' ".$res_extra." LIMIT 1";
       $res = $this->dbQuery($sqlstring);
       $tmp= $this->dbFetchArray($res);

       return $tmp[0];
    }//dbGetField

    /* backwards compatibility */
    function dbGetFieldW($field,$id,$match) {
       return $this->dbGetField($field,$id,$match,LANGUAGE);
    }//dbGetFieldW

    /* backwards compatibility */
    function dbGetFieldN($field,$id,$match) {
       return $this->dbGetField($field,$id,$match,'N');
    }//dbGetFieldN


    /*==============================================================
      FUNCTIONS FOR MANIPULATING THE TABLES
      ==============================================================*/

    /**
     * Add column to currently selected table.
     * @param string Name of column.
     * @param string Add column after this column.
     * @param string Column type
     * @access public
     **/
    function dbAddColumn($name,$after=0,$type='blob') {
       $type=pg_change_type($type);
       if($after){
      // put current table in var before something fucks with it
      $workingtable=$this->table;

      // get fields in old table
      $res = $this->dbDescribeTable($workingtable);

      // get rows int old table
      $rows_res = $this->dbQuery("SELECT * FROM $workingtable");

      // create table array
      $arrCreate=array();
      while($field=$this->dbFetchArray($res)){
         $arrCreate[$field[0]]=$field[1];
         if ($field[0]==strtolower($after))
        $arrCreate[$name]=$type;
      }

      // delete old table
      $this->dbDeleteTable();

      // create our new funky table
      $this->dbCreateTable($arrCreate,$workingtable);

      // and set table again (was delete by dbDeleteTable)
      $this->table=$workingtable;

      // insert rows!
      $numfields=$this->dbNumFields($rows_res);

      while($row=pg_fetch_array($rows_res)){
         foreach($row as $key=>$value){
        if (!is_numeric($key)) {
           $arrIns[$key]=$value;
        }
         }
         $this->dbInsert($arrIns);
      }

       } else {
      $res = @$this->dbQuery("ALTER TABLE ".$this->table." ADD COLUMN $name $type");
       }
    }//dbAddColumn

    /**
     * Delete column from currently selected table.
     * @param string Name of column.
     * @access public
     **/
    function dbDeleteColumn($name) {
       $res = $this->dbQuery("ALTER TABLE ".$this->table." DROP COLUMN $name");
    }//dbDeleteColumn

    /**
     * Rename column in currently selected table.
     * @param string Source name.
     * @param string Destination name.
     * @param string Column type.
     * @param string 
     * @access public
     **/
    function dbRenameColumn($name,$newname,$type='text',$default='NULL') {
       $type=pg_change_type($type);
       $res = $this->dbQuery("ALTER TABLE ".$this->table." RENAME ".$name." TO  ".$newname);
    }

    /**
     * Copies a row and returns a the new id.
     * Notice: This function is specific to Fundanemt and should
     * not be used unmodified elsewhere.
     * @param int Source id
     * @return int Id of new row.
     * @access public
     **/
    function dbCopyRow($id) {

       $res = $this->dbQuery("SELECT * FROM ".$this->table." WHERE ID='".$id."'");
       $p = $this->dbFetchArray($res);
       $newId = $this->dbFetchId();

       while(list($key,$value) = each($p)) {
      if($key == "ID") $arrInsert["condition"] = "ID='".$newId."'";
      elseif(!is_numeric($key)) $arrInsert[$key] = addslashes($value);
       }//while

       if($arrInsert["TYPE"] == "TABLE") {
      //get new tablename
      $arrTables = $GLOBALS["D"]->dbListTables();

      foreach($arrTables as $table) {
         if(preg_match("/fundaTable([0-9]+)/i",$table,$arrayMatch))
        $count = ($arrayMatch[1] < $count)?$count:$arrayMatch[1];
      }//foreach

      $tableName = "fundaTable".(++$count);

      //copy table
      $GLOBALS["D"]->dbCopyTable($tableName,$arrInsert["CONTENT"]);

      //assign value.
      $arrInsert["CONTENT"] = $tableName;
       }//if

       if(isset($arrInsert["OWNER"])) $arrInsert["OWNER"] = $GLOBALS["U"]->username;
       if(isset($arrInsert["TIMESTAMP"])) $arrInsert["TIMESTAMP"] = mktime();

       $this->dbUpdate($arrInsert);
       return $newId;

    }//dbCopyRow

    /*==============================================================
      BASIC FUNCTIONS
      ==============================================================*/
    /**
     * Get row array from resultset.
     * @param resultset
     * @return array
     * @access public
     **/
    function dbFetchArray($resid) {
       if ($res = @pg_fetch_array($resid)) {
      return change_array_case($res);
       }
    }//dbFetchArray

    /**
     * Perform query and return resultset.
     * @param string Query
     * @return resultset
     * @access public
     **/
    function dbQuery($sql) {
        $sqlbefore=$sql;
        $sql=preg_replace("/(?<!\\\\)\"/","'",$sql);
        $sql=preg_replace("/= *''/","=NULL",$sql);
        $i = 1;
        while ($i <= $this->settings['retries']) {
            if ($res = @pg_query($this->dblink,$sql)) {
                return $res;
            }
            $i++;
        }

        // We did not get a result in the maximum number of retries.
        $this->error();
    }//dbQuery

        /**
         * Get number of rows in resultset.
         * @param resultset
         * @return int
         * @access public
         **/
        function dbNumRows($res) {
            return @pg_num_rows($res);
        }//dbNumRows

        /**
         * Check if table exists.
         * @param string Override currently selected table.
         * @return boolean
         * @access public
         **/
        function dbExists($table=false) {
           $table = $table?$table:$this->table;

           $sql = "SELECT 1 FROM pg_tables WHERE tableowner='" . DB_USER . "' AND tablename='" . strtolower($table) . "'"; 

           return pg_num_rows(pg_query($this->dblink,$sql)); 
        }//dbExists

        /**
         * Check if column is in table.
         * @param string Name of column to check.
         * @return boolean
         * @access public
         **/
        function dbInTable($field,$table=0) {
           $table = $table ? $table : $this->table;

           $res = pg_list_fields(DB,$table,$this->dblink);
           while($row = $this->dbFetchArray($res)) {
              if($row[0] == strtolower($field)) {
             return true;
              }
           }
           return false;
        }//dbInTable

        /**
         * Insert new empty row into currently selected table.
         * @param string id - the name of the id-column in your table - default is ID
         * @return int Id of new row.
         * @access public
         **/
        function dbFetchId($id = "ID") {
           $res = $this->dbQuery("SELECT MAX(" . $id . ") from ".$this->table);
           if($res) {
              $maxID = array_pop($this->dbFetchArray($res));
              $maxID++;
           } else {
              $maxID = 1;
           }
           $res = $this->dbQuery("INSERT INTO ".$this->table." (" . $id . ") values ($maxID)");
           return $maxID;
        }//dbFetchId

        /**
         * Set result pointer to a specified field offset
         * @param resultset-reference
         * @param int Field offset in resultset.
         * @access public
         **/
        function dbFieldSeek(&$res,$field) {
           // homemade, look in custom functions section
           pg_field_seek($res,$field);
        }//dbFieldSeek

        /**
         * Get column information from a result and return as an object.
         * @param resultset-reference
         * @param int Field offset in resultset.
         * @access public
         **/
        function dbFetchField(&$res,$field='') {
           // Look for pg_fetch_field in the custom pg functions section!
           if($field) {
              return pg_fetch_field($res,$field);
           } else {
              return pg_fetch_field($res);
           }
        }//dbFetchField

        /**
         * Number of fields in resultset.
         * @param resultset-reference
         * @return int
         * @access public
         **/
        function dbNumFields(&$res) {
           return pg_num_fields($res);
        }//dbNumFields        

        /**
         * Move internal pointer to given row.
         * @param resultset-reference
         * @param int
         * @access public
         **/
        function dbDataSeek(&$res,$row) {
           return pg_result_seek($res,$row);
        }

        /**
         * Returns an array where each row contains the tablename and
         * fieldname, where string was found.
         * If searchTables is ommitted it will search all tables in database.
         * @param string Text to search for
         * @param array List of tables to search through.
         * @access public
         **/
        function dbFindString($string, $searchTables=0) {
           $fieldTypes=array("text","longtext","varchar","blob","char","text","bytea");
           if($searchTables){
              $tables=$searchTables;
           }else{
              $tables=$this->dbListTables();
           }

           foreach($tables as $CurrTable){
              $res_desc=$this->dbDescribeTable($CurrTable);
              $textfields=array();

              while($field=$this->dbFetchArray($res_desc)) {
             if(array_search($field[1],$fieldTypes)!==FALSE){
                $sql="SELECT " . $field[0] . " FROM $CurrTable WHERE " . $field[0] . " LIKE '%" . $string . "%'";
                $res=$this->dbQuery($sql);
                if($row=$this->dbFetchArray($res))
                   $arrOutput[$CurrTable]=$field[0];
             }// if
              }// while
           }// foreach

           if(isset($arrOutput))
              return $arrOutput;
           else
              return false;
        }//dbFindString        

        /**
         * Get database dump of all tables.
         * @return string Database dump.
         * @access public
         **/
        function dbDump() {
           $ArrTables = $this->dbListTables();
           foreach ($ArrTables as $tablename){
              // get description of table
              $desctable = $this->dbDescribeTable($tablename);

              // set fields =0
              $fields=0;

              // contruct table string
              $table = "--\n-- Table structure for table `$tablename`\n--\n\n";
              $table .= "CREATE TABLE $tablename (\n";

              while ($row = $this->dbFetchArray($desctable)){
             $fields=$fields+1;
             $table .= "  $row[0] $row[1],\n";
              }
              $table = substr($table, 0, strlen($table)-2);
              $table .= "\n);\n\n";
              $o .= $table;
              $sql=substr($sql,0,strlen($sql)-2);

              // get rows in table
              $allrows = $this->dbQuery("select * from $tablename");
              while ($row = $this->dbFetchArray($allrows)) {
             $insert = "INSERT INTO $tablename VALUES(";

             for ($i=0; $i<count($row)/2; $i++) {
                if(strlen($row[$i])==0) $insert .= "NULL,"; 
                else $insert .= "'".addslashes($row[$i])."',";
             }    

             $insert = substr($insert, 0, -1);
             $o .= $insert.");\n";
              }
           }
           return $o;
        }//dbDump

        /*==============================================================
          ERROR HANDLING
          ==============================================================*/
        function error() {
           print pg_last_error($this->dblink);
           exit;
        }//error
}//dataBase

/*==========================================================
  HOMEMADE FUNCTIONS NEEDED FOR THE POSTGRESQL TRANSLATION
  ===========================================================*/
function pg_list_tables($dblink) 
{   
   $sql = "SELECT tablename FROM pg_tables WHERE tableowner='" . DB_USER . "'"; 
   return (pg_query($dblink,$sql)); 
}//pg_list_tables

function pg_list_fields($database, $table, $dblink){
   $sql="SELECT
      a.attname,
      format_type(a.atttypid, a.atttypmod),
      a.attnotnull,
      a.atthasdef,
      a.attnum
     FROM
     pg_class c,
      pg_attribute a
     WHERE
     c.relname = '" . $table . "'
     AND a.attnum > 0 AND a.attrelid = c.oid
     ORDER BY a.attnum";

   return pg_query($dblink,$sql);
}//pg_list_fields

function pg_change_type($oldtype){
   switch($oldtype){
      case "longtext":
     $type="text";
      break;
      case "tinyint":
     $type="integer";
      break;
      case "blob":
     $type="bytea";
      break;
      default:
      $type=$oldtype;
      break;
   }

   return($type);
}//pg_change_type

function change_array_case($array){
   $newarr=array();
   foreach($array as $key=>$value) {
      $newarr[strtoupper($key)]=$value;
   }
   return $newarr;
}//change_array_case

// this class is for the homemade pg_fetch_field function
class dbPgField{
   var $type;
   var $name;
}//dbPgField

// emulator thingy like the mysql_field_seek function
function pg_field_seek($res,$fieldnum=0){
   if ($fieldnum) {
      $GLOBALS['field_seek'][$res]=$fieldnum;
   } else {
      if ($GLOBALS['field_seek'][$res]) {
     $GLOBALS['field_seek'][$res]++;
      } else {
     $GLOBALS['field_seek'][$res]=1;
      }
   }
}//pg_field_seek

function pg_fetch_field($res,$fieldnum=0){
   if ($fieldnum==0 && ($GLOBALS['field_seek'][$res])) {
      foreach($GLOBALS['field_seek'] as $resource=>$num) {
     if($resource==$res) {
        $fieldnum=$num;
     }
      }
   }
   $fieldInfo= new dbPgField;
   $fieldInfo->type=@pg_field_type($res,$fieldnum);
  // $fieldInfo->name=strtoupper(@pg_field_name($res,$fieldnum));
   $fieldInfo->name=strtolower(@pg_field_name($res,$fieldnum));

   if($GLOBALS['field_seek'][$res]) {
      $GLOBALS['field_seek'][$res]++;
   } else {
      $GLOBALS['field_seek'][$res]=1;
   }

   if (!$fieldInfo->name) {
      return false;
   }

   return $fieldInfo;
}//pg_fetch_field


//returns an array with infos of every field in the table (name, type, length, size)
function pg_Fields_Info(){
	 $conn = db_connect(); 
    $s="SELECT a.attname AS name, t.typname AS type, a.attlen AS size, a.atttypmod AS len, a.attstorage AS i ,a.attnotnull AS notnull
    FROM pg_attribute a , pg_class c, pg_type t 
    WHERE c.relname = '".$_SESSION["table"]."'  
    AND a.attrelid = c.oid AND a.atttypid = t.oid";
    
    if ($r = pg_query($conn,$s)){
        $i=0;
        while ($q = pg_fetch_assoc($r)){
               $a[$i]["type"]=$q["type"];
               $a[$i]["name"]=$q["name"];
               if($q["len"]<0 && $q["i"]!="x"){
                   // in case of digits if needed ... (+1 for negative values)
                   $a[$i]["len"]=(strlen(pow(2,($q["size"]*8)))+1);
               }else{
                   $a[$i]["len"]=$q["len"];
               }
               $a[$i]["size"]=$q["size"];
			   $a[$i]["notnull"]=$q["notnull"];
            $i++;            
        }
        return $a;
    }
    return null;
}


?>

