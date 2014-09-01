var commentsList  = new TabList({
	filterTab: $('#filter_comment').children('li'),
	publish: $('#publish_comment'),
	unpublish: $('#unpublish_comment'),
	allpublish: $('#allpublish_comment'),
	publishLink: $('#publish_link_comment'),
	unpublishLink: $('#unpublish_link_comment'),
	allpublishLink: $('#allpublish_link_comment'),
	publishNav: $('.nav_publish'),
	unpublishNav: $('.nav_unpublish'),
	allpublishNav: $('.nav_all')
});

commentsList.publish.hide();
commentsList.unpublish.hide();
commentsList.publishNav.hide();
commentsList.unpublishNav.hide();

commentsList.activeClass();

commentsList.tabContent(commentsList.allpublishLink, commentsList.publish, commentsList.unpublish, commentsList.allpublish, commentsList.publishNav, commentsList.unpublishNav, commentsList.allpublishNav);
commentsList.tabContent(commentsList.publishLink, commentsList.unpublish, commentsList.allpublish, commentsList.publish, commentsList.allpublishNav, commentsList.unpublishNav, commentsList.publishNav);
commentsList.tabContent(commentsList.unpublishLink, commentsList.allpublish, commentsList.publish, commentsList.unpublish, commentsList.allpublishNav, commentsList.publishNav, commentsList.unpublishNav);

