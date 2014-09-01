'use strict';

function TabList(defaults){
	defaults = defaults || {};

	this.filterTab = defaults.filterTab;
	this.publish = defaults.publish;	
	this.unpublish = defaults.unpublish;	
	this.allpublish = defaults.allpublish;
	this.publishLink = defaults.publishLink;
	this.unpublishLink = defaults.unpublishLink;
	this.allpublishLink = defaults.allpublishLink;
	this.publishNav = defaults.publishNav;
	this.unpublishNav = defaults.unpublishNav;
	this.allpublishNav = defaults.allpublishNav;
}

TabList.prototype.activeClass = function(){
	var that = this;

	that.filterTab.click(function(e) {
		e.preventDefault();
		that.filterTab.removeClass('active');
		$(this).addClass('active');
	});
};

TabList.prototype.tabContent = function(link, p1, p2, p3, n1, n2, n3){
	link.click(function(e) {
		e.preventDefault();
		p1.hide();
		p2.hide();
		p3.show();
		n1.hide();
		n2.hide();
		n3.show();
	});
};
