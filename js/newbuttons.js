(function () {
    'use strict';

    tinymce.PluginManager.add('youtube_subscriber', function (editor, url) {
        editor.addButton('youtube_subscriber', {
            title: 'Youtube Subscriber',
            image: url + '/../image/official-youtube-logo-tile_25x25.png',

            onclick: function () {
                editor.windowManager.open({
                    title: 'Enter your YouTube nickname or channel name (Id)',
                    body: [
                        {
                            type: 'textbox',
                            size: 40,
                            name: 'nickname',
                            label: 'Nickname'
                        },
                        {
                            type: 'container',
                            name: 'container',
                            label: '',
                            html: '<h1 style="text-align: center">OR<h1>'
                        },
                        {
                            type: 'textbox',
                            size: 40,
                            name: 'channelname',
                            label: 'Channel name'
                        },
                        {
                            type: 'textbox',
                            size: 40,
                            name: 'channelID',
                            label: 'Channel ID'
                        },
                        {
                            type: 'listbox',
                            name: 'layout',
                            label: 'Layout',
                            values: [
                                {text: 'Default', value: 'default'},
                                {text: 'Full', value: 'full'}
                            ]
                        },
                        {
                            type: 'listbox',
                            name: 'subscribers',
                            label: 'Subscribers',
                            values: [
                                {text: 'Default (show)', value: 'default'},
                                {text: 'Hide', value: 'hidden'}
                            ]
                        }
                    ],
                    onsubmit: function (e) {
                        if (e.data.nickname != "" && e.data.nickname != null) {
                            editor.insertContent('[youtube-subscriber nickname=' + e.data.nickname + ']');
                        }
                        else if (e.data.channelname != "" && e.data.channelname != null) {
                            editor.insertContent('[youtube-subscriber channelname=' + e.data.channelname +
                            ' layout=' + e.data.layout + ' subscribers=' + e.data.subscribers + ']');
                        }
                        else if (e.data.channelID != "" && e.data.channelID != null) {
                            editor.insertContent('[youtube-subscriber channelID=' + e.data.channelID +
                            ' layout=' + e.data.layout + ' subscribers=' + e.data.subscribers + ']');
                        }
                    }
                });
            }
        });
    });
})();


