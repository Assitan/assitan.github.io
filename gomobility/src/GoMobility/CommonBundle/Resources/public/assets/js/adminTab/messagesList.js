var messagesList  = new TabList({
	filterTab: $('#filter_message').children('li'),
	publish: $('#received_message'),
	unpublish: $('#sent_message'),
	allpublish: $('#all_message'),
	publishLink: $('#received_link_message'),
	unpublishLink: $('#sent_link_message'),
	allpublishLink: $('#all_link_message'),
	publishNav: $('.nav_publish'),
	unpublishNav: $('.nav_unpublish'),
	allpublishNav: $('.nav_all')
});

messagesList.allpublish.hide();
messagesList.unpublish.hide();
messagesList.allpublishNav.hide();
messagesList.unpublishNav.hide();

messagesList.activeClass();

messagesList.tabContent(messagesList.allpublishLink, messagesList.publish, messagesList.unpublish, messagesList.allpublish, messagesList.publishNav, messagesList.unpublishNav, messagesList.allpublishNav);
messagesList.tabContent(messagesList.publishLink, messagesList.unpublish, messagesList.allpublish, messagesList.publish, messagesList.allpublishNav, messagesList.unpublishNav, messagesList.publishNav);
messagesList.tabContent(messagesList.unpublishLink, messagesList.allpublish, messagesList.publish, messagesList.unpublish, messagesList.allpublishNav, messagesList.publishNav, messagesList.unpublishNav);