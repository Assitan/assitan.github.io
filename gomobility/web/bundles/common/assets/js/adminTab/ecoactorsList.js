var ecoactorsList = new TabList({
	filterTab: $('#filter_ecoactor').children('li'),
	publish: $('#publish_ecoactor'),
	unpublish: $('#unpublish_ecoactor'),
	allpublish: $('#allpublish_ecoactor'),
	publishLink: $('#publish_link_ecoactor'),
	unpublishLink: $('#unpublish_link_ecoactor'),
	allpublishLink: $('#allpublish_link_ecoactor'),
	publishNav: $('.nav_publish'),
	unpublishNav: $('.nav_unpublish'),
	allpublishNav: $('.nav_all')
});

ecoactorsList.publish.hide();
ecoactorsList.unpublish.hide();
ecoactorsList.publishNav.hide();
ecoactorsList.unpublishNav.hide();

ecoactorsList.activeClass();

ecoactorsList.tabContent(ecoactorsList.allpublishLink, ecoactorsList.publish, ecoactorsList.unpublish, ecoactorsList.allpublish, ecoactorsList.publishNav, ecoactorsList.unpublishNav, ecoactorsList.allpublishNav);
ecoactorsList.tabContent(ecoactorsList.publishLink, ecoactorsList.unpublish, ecoactorsList.allpublish, ecoactorsList.publish, ecoactorsList.allpublishNav, ecoactorsList.unpublishNav, ecoactorsList.publishNav);
ecoactorsList.tabContent(ecoactorsList.unpublishLink, ecoactorsList.allpublish, ecoactorsList.publish, ecoactorsList.unpublish, ecoactorsList.allpublishNav, ecoactorsList.publishNav, ecoactorsList.unpublishNav);