_uacct = "UA-163788-1";
urchinTracker();

ToolTip = function(o, t, c, f){
	var i, $ = this;
	$.s = ($.o = document.createElement("div")).style;
	$.s.display = "none", $.s.position = "absolute", $.o.className = c, $.t = t, $.f = f;
	for(i in {mouseout: 0, mouseover: 0, mousemove: 0})
		addEvent(o, i, function(e){$[e.type](e);});
};
with({p: ToolTip.prototype}){
	p.update = function(e){
		var w = window, b = document.body;
		
		
		this.s.top = e.clientY +  b.scrollTop  - 25 + "px",
		//this.s.top = e.clientY + 90 - (w.scrollY || b.scrollTop || b.parentNode.scrollTop || 0) + "px",
		this.s.left = e.clientX - 5 - (w.scrollX || b.scrollLeft || b.parentNode.scrollLeft || 0) + "px";
	}	

	p.mouseout = function(){
		this.s.display = "none";
	};
	p.mouseover = function(e){
		this.s.display = "block", document.body.appendChild(this.o).innerHTML = this.t,
		e.stopPropagation(), this.update(e);
	};
	p.mousemove = function(e){
		this.f && this.update(e);
	};
}
//]]>