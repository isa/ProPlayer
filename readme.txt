=== ProPlayer ===
Contributors: isa.goksu
Donate link: http://isagoksu.com/donations/
Tags: youtube, vimeo, google, veoh, myspace, dailymotion, youku, flv, mp4, mp3, avi, mov, video, embed
Requires at least: 2.7
Tested up to: 2.8.6
Stable tag: tags/4.7.7

Display videos from various online sources (YouTube, Vimeo, Veoh, etc) in one single player, 27 different skins, playlist system, rating system, etc.

== Description ==

Places online videos (YouTube, Vimeo, Veoh, Youku, Dailymotion, etc..) into your post by using JW FLV Player. 10,000 downloads in first 2 months, and still counting! Here are couple nice features: 27 different Skins, Custom Playlists, Youtube Playlists, Video Ratings, Audio Visualizer, Displaying Watermarks, and much more.. 

Currently supported video sources are:

* All files that you've uploaded to your server (movies, images, etc..)
* Dailymotion
* Google Video 
* MySpace 
* Veoh (music videos are not supported)
* Vimeo 
* Youtube (with playlists)
* Youku
* With a little help, new sources could be added soon..

Now with flashvar overrides, displayable playlists, flow view, subtitle support, keyboard navigation.

Above videos are supported, however all their rights are reserved to their certified owners. Currently I don't support to put their watermark logos for each video. I'll add this feature in near future. Till I add these options, if there is any legal issue, please try to fix it by yourself since it's open source.

== Installation ==

It's pretty simple to install. Just follow the common intention:

1. Unzip the plugin file, it will create a directory named `proplayer`
1. Upload the directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

That's it. The usage is like this:

        [pro-player]http://www.youtube.com/watch?v=2YAvfxA6a94[/pro-player] 
        [pro-player width="500" height="500"]http://vimeo.com/1473498[/pro-player]
        [pro-player type="mp4"]http://www.mydomain.com/media/awesome.mp4[/pro-player]

If you're a template developer or you want to show a video in a fixed position in the site:

		<?php 
		    print insert_proplayer(
		         array(
		            "width" => "530",
		            "height" => "213",
		            "playlist" => "bottom"
		         ),
		         "http://www.youtube.com/watch?v=2YAvfxA6a94"
		    ); 
		?>

For more information about video sources and their addresses syntax, just visit my blog. You'll see a page that explains it. Please <a href="http://isagoksu.com/video-tests">go visit</a>

== Frequently Asked Questions ==

= Do I have to provide full video URL or just some part of it? =

Yes, you have to provide full video URL. ProPlayer doesn't work if you just place some part of the URL. Please check following usages;

        [pro-player]http://www.youtube.com/watch?v=2YAvfxA6a94[/pro-player]

= Are you gonna support more video resources? =

Actually, I've created this plugin for my blog. And I thought all these video sources are enough. However, if there is a big demand for other video sources, I can implement them too.

= Can ProPlayer play mp3 files? =

Yes, ProPlayer supports any of the following file types:

  video: [3g2, 3gp, aac, f4b, f4p, f4v, flv, m4a, m4v, mov, mp4, sdp, vp6]
  image: [gif, jpg, png, swf]
  sound: [rbs, mp3]

The only thing you need to do is adding a type attribute for your video file if it is other than FLV:

        [pro-player type="MP3"]http://www.trt.net.tr/medya/ses/2008/11/19/09be6054-1829-4cac-b068-e9493200196c.mp3[/pro-player]
        [pro-player type="JPG"]http://www.mydomain.com/albums/summer/1.jpg[/pro-player]

= How can I use ProPlayer in my header or any fixed position? =

Please check the usages/installation section. Basically, you need to call pro-player function with above pro-player snippets.

		<?php 
		    print insert_proplayer(
		         array(
		            "width" => "530",
		            "height" => "213",
		            "playlist" => "bottom"
		         ),
		         "http://www.youtube.com/watch?v=2YAvfxA6a94"
		    ); 
		?>

You can place above usage to anywhere in your WordPress site.

= Can I change the width and height? =

Width, height and type are optional attributes. You can pass these attributes to change the width and height: 

        [pro-player width="500" height="500"]http://vimeo.com/1473498[/pro-player] 	

Defaults for these attributes will be used if you don't pass them. And defaults are 'width' = 530, 'height' = 253. If you wanna change the defaults just go and edit plugin source. It's really easy. 

= Isn't there any button or something to add a new video? =

Yeah, if you don't wanna type things, just use the editor button to add a new video. It's so easy. (This feature only available after 2.0 release)

= Can I change the theme of the player? = 

Yes you can. You can even add some add-ons like Ad system, etc.. Just check the addons page site <a href="http://www.longtailvideo.com/addons" target="_new">JW FLV Media Player</a> for details.

= Isn't there an easy way to change these skins? =

Yes there is. Just go to the options page. You'll see a bunch of (26) new skins on top of the default one. Just change it and it will apply to all your players immediately.

= Can I style a little bit more? =

Yes, if you wanna style your player container like adding borders, changing background etc, just 
define "div.pro-player-container" in your CSS file:

        div.pro-player-container {
        	border: 1px solid red;
        }

= I wanna change player colors? =

It is easy. Go to ProPlayer settings page in your WordPress admin panel, you are gonna see whole bunch of extra settings.

= I wanna stretch my video? =

Read above answer.

= I'm having some errors? =

First of all, I'm really appreciated everyone's support and interest. However, I wrote this plugin for myself. So it has just semi-advanced functionalities. And there might be bugs too since I don't have any business requirements other than show my own videos (youtube and vimeo videos). So if you're having some trouble, please send me an email with "site url, what did you write in your post (from your admin panel), contact information", or add a comment on <a href="http://isagoksu.com/proplayer-wordpress-plugin/">project page</a>. I'll try to get back to you in ASAP. And please don't forget I've a job to go in day time.

= I wanna follow project =

You can add me on twitter http://twitter.com/IsaGoksu or you can just follow the project page. I'll try to update as much as possible.

= I want MegaVideo? =

Guys I'm really sorry for that, but today I looked at megavideo site. And their video API is full of ads. If you don't have premium account (which I don't have), writing something over that API is really tricky, 'coz every time you develop something, they will change the API according to their needs. Free service doesn't have a fixed API. If the demand for that site is so high, I'll look at again. But for now, I don't wanna spend so much energy on that. 

= How can I add rating system for my videos? =

Just check options page.

= Is there any chance to add visualizer for my audio files? =

Read above answer. Just one thing here is Visualizer plugin requires you to use your own mp3 files. If you're refering to another host/URL, make sure that host/URL has crossdomain.xml configured for your access. For more details, please look at the Adobe's site.

Another thing about visualizer plugin is; it will block your preview images.

= I wanna show some watermark/logo for my videos =

Check the options page. One thing you need to know is, place your watermark image under proplayer/players/watermark.png. It has to be transparent. And when this option is enabled, you cannot use visualizer for your audio files.

= I see dead people :P, no no, I just started to see IG logo after upgrading 2.0? =

Well, read above answer. It's default watermark. If you wanna turn it off, go to options page.

= I can't see the preview of the video if I don't press play? =

After version 4.0, you can see preview image of the videos.

And, if you also want to add custom images to your video, either you can use proplayer window or you can use following syntax:

        [pro-player image='http://myserver.com/superimage.jpg']myvideo-url[/pro-player]

If you just wanna show a default preview image for all your videos, you can check options page, you'll see an option for that.

= How about playlist support? =

After version 2.7 you can have playlists. Playlist works by only adding comma separated files into the player code, or by providing a youtube playlist. If you do add comma separated files, ProPlayer will automatically create a playlist from given list. If you provide a youtube playlist, ProPlayer automatically retrieve your playlist files in a sequential order.

One side note here: If you add videos from multiple video sources (youtube, vimeo, veoh, etc), player work perfectly fine. However you should consider that there will be an overhead on retrieving file information process from all those sources. And this will cause longer page loads unless it's not cached. After version 4.0, caching will handle your site speed.

= What about displaying playlist? =

Just tell which position you want to ProPlayer:

        [pro-player playlist="bottom"] my video url [/pro-player]

= I added multiple files, but my playlist doesn't automatically start? =

You need to provide autostart attribute and set it true. Please read related FAQ about autostart.

= Well, when I do autostart=true it just plays the first one and stops? =

If you want ProPlayer to automatically advance songs/videos, please set repeat=true too. Please read related FAQ about repeat.

= OK this time, I set both options and my playlist starts automatically and plays forever? =

If you don't want to play automatically, leave repeat as true, and set only autostart to false. By this way, your visitors can play and listen it forever, or if they want they can pause it again. It's up to them.

= How can I create custom playlist? =

Just add your files in comma separated form. Please read above answers for more information. Usage:

        [pro-player repeat='true']http://mydomain.com/my-song-1.mp3,http://mydomain.com/my-song-2.mp3,http://mydomain.com/my-song-3.mp3[/pro-player]        

= Can I enable auto play? =

Yes you can, just use the new 'Add Video' dialog by pressing ProPlayer button or type following into your post:

        [pro-player autostart='true']http://mydomain.com/my-awesome-video.flv[/pro-player]

= Can I enable repeat option? =

Yes you can, just use the new 'Add Video' dialog by pressing ProPlayer button or type following into your post:

        [pro-player repeat='true']http://mydomain.com/my-awesome-video.flv[/pro-player]

= Can I Add RTMP streaming files? =

Yes you can. Just give the file name(s) comma separated and define the RTMP server in the ProPlayer dialog. When you define RTMP server, you can only use RTMP server files.

= Is there a caching support? =

Yes, after 4.0.

= Can I turn the caching off? =

Sure, just go to the options page and set cache timeout to 0.

= I wanna share or let other people to embed my videos? =

You can do it. Please enable the sharing/embedding support or go to the options page and check new features :P

= I wanna show my player on the sidebar? =

After version 4.0, you can use sidebar as your player location. Please add a sidebar widget, and drop your ProPlayer snippet there.

= Can I use Longtail AdSolutions? =

Yes you can. It's so easy. Go to options page and follow the instructions. If you don't know what's Longtail AdSolutions, please visit <a href="http://www.longtailvideo.com/referral.aspx?page=pubreferral&ref=mhrjtrstbyxqwn" target="_new">Longtail AdSolutions</a> and grab your free account before they change their mind about free use :P

= I can't post 2 videos in the same post? =

Yes you can. The only thing you need to do is upgrade the plugin to 2.0+ version.

= Sometimes I see this video is not available? =

It means that your video link is broken, or the video server blocked your server's IP range for a certain time/or all times. Guys, this is very common problem. All of you know that we're retrieving those sites' videos by some tricky codes. Not every service has an API like YouTube. If they don't wanna share their video with your server, I can't do a much there :S I'm sorry. Then again, just try again after some time. Maybe it might work. 

= Well, but other players are showing those videos? =

Well, those players are default players of the above sites. Like if you embed DailyMotion's default player to show dailymotion video, it's gonna work most probably. But all of us know that most of those sites' players are crap. That's why I created this plugin, just to keep site's visual look & feel, and add some skin support. If this player doesn't play those videos, try to embed video source's player to your post. There are some nice plugins for that like Viper's plugin.

= Veoh movies are just 5 minutes? =

Well, veoh released a new player for desktops. If you don't have premium account, you can only watch preview from the web. If you wanna watch full movies, you should download their desktop media player.

= Is there a PHP 4 support? =

I really don't have any machine to test PHP4 right now. However, I removed the version check. I assume it's gonna work without any problem.

= Are you planning to give support for old PHP4 releases? =

Yes, definitely. However, after 2.7 release, I had to remove PHP4 support since it doesn't built-in support XML operations. PHP4 users can use plugin up to version 2.0.1.

One thing is I'm too busy for a long time. And I really don't have much time to add this right now. Any help would be awesome :)

= I'm having some PHP errors? =

Guys, I'm trying this plugin in 2 different servers which they have different settings and setup. As I wrote above, if you've PHP version 5+, you shouldn't see any errors. Then again, I tried to put some extra code to just adjust a little bit more support on early PHP 5 versions. But still no PHP 4 support. If you have PHP 4 on your server, please use version 2.0.1. 

If you don't know what is PHP, or what version you have, please ask it to your hosting company by mail. They will tell you.

If you're using PHP5 and still getting some error, it's most probably your server is missing lib-xml and php-xml installation. Please ask them to do this:

* For windows servers, just install the lib-xml and enable the php-xml/lib-xml extension from the php.ini
* For Redhat Linux: yum install php-xml, and enable lib-xml extension
* For Debian based Linux: apt-get install php-xml, and enable lib-xml extension
* For MacOSX based server: port install php-xml if they needed

= My Country doesn't support YouTube? =

Just delete the youtube.php file under video-sources folder and rename the youtube.proxy.php file to youtube.php. This will allow you to get YouTube videos through proxy.

= Isn't there a Wordpress 2.x support? =

Truely I have no clue :P. I just never tried. Maybe you can try and let us know?

= Can I copy your code for my own web projects? =

I've changed the license from GPL to BSD. So you can do whatever you want. If you wanna use in commercial project, do it! If you wanna change the player code just do it! The only thing here is I'm using JW Media Player. It's license is under GPL. You need to note that.

If you want support or custom modifications, but you don't know how to do just drop me an e-mail and let's take it from there.

= Do you need help? =

Yes pleaseeeeee! I cannot spend all my spare time to the plugin guys.. I need help!

== Screenshots ==

Here are some screenshots from the player.

1. In the post
2. Single
3. Customizable colors, width, height, stretching, etc..
4. New skins (26 new) and visualizer option for audio files
5. Rating system
6. Watermark/logo display
7. Options page
8. Preview Image before video starts
9. New Editor Enhancement
10. New Toolbar Button
11. New Quicktag
12. Youtube playlist support, auto play, repeat options.
13. Song playlist while playing
14. New options
15. Longtail AdSolutions support
16. Cache support
17. Flow View
18. Subtitle support

== Some Notes ==

I've added simpletest support to the project. And I'm also releasing 4.7.5 with unit tests. So developers who want to continue on that are more than welcome :)

== Change History ==

version 4.7.7

* Minor Bug fixes (like IE7 problem)

version 4.7.6

* Visualizer plugin support disabled by default
* Markdown plugin conflict which causes youtube playlist, dailymotion and youku problems is fixed
* Same image was shown for the playlist, fixed now
* Minor Bug fixes

version 4.7.5

* Support for displaying playlist on desired position
* FlashVar overrides, please look at the all supported flashvars from: <a href="http://developer.longtailvideo.com/trac/wiki/FlashVars">author's site</a>
* Flow View support for media files in the playlist
* Subtitle support
* Shortcut support: Up/Down arrow keys for Volume Up/Down, Left/Right arrow keys for Pre/Next media file
* RTMP syntax change
* Quicktags syntax change
* Bug fixes for custom preview image, dailymotion, and veoh

version 4.5.1

* Support for fixed positions, custom pages and templates
* Dailymotion bug is fixed
* Some conflicts with other plugins has been removed
* Minor bug fixes

version 4.5

* Youku support
* Title support for each video source
* Session based XML playlists are replaced by DB based XML playlists
* In playlists, each video has its own preview image
* User/Server related problems are grouped into a single error
* All video calculations are speeded up
* Lots of bug-fixing
* Lots of refactorings

version 4.0.5

* YouTube access speed up
* Direct YouTube access and YouTube over proxy support
* Some minor bug fixes

version 4.0

* Major architectural changes
* Full preview image support
* Caching support
* Cache timout option
* Enhanced Youtube support
* Sidebar player support (add as widget)
* Re-supported Dailymotion
* JW Media player upgraded to 4.4
* Google video fix
* Youtube fix
* Complete cURL implementation

version 3.0

* Longtail AdSolutions support
* Embedding / Sharing support (Viral)
* RTMP streaming support
* HD video support for YouTube
* Minor enhancements and refactorings

version 2.8.6

* Image attribute for setting custom preview images has been added.
* Permalink and tag cloud bug is fixed.
* XML problems are fixed.
* More PHP bug-fixes.

version 2.7.7

* JW FLV Media Player downgraded since it has dynamic playlist bugs
* Stupid WP design problem (comes with register globals option) that causes the those stupid PHP problems is fixed.
* Register Globals support (Please try to use register_globals = off for your security, if your host is not doing this, they've definitely misunderstanding on how PHP works, PHP6 doesn't even contain register globals option anymore..)

version 2.7.5

* JW FLV Media Player upgraded to 4.3
* Couple more stupid PHP warnings are fixed for early releases (5.0, 5.0.x, etc)
* More wider PHP support

version 2.7.1

* Couple stupid PHP warnings are fixed for early releases (5.0, 5.0.x, etc)
* More wider PHP support

version 2.7

* Youtube playlist support
* Custom playlists
* Multiple playlist (one custom, one youtube, etc)
* Added auto play option to the options page
* Added repeat option to the options page
* Added auto play support (by adding autostart='true')
* Added repeat support (by adding repeat='true')
* Some minor bug fixes to increase PHP support
* Title bug fix for rating system
* Performance optimizations

version 2.0.1

* Bug fix for uniqid() warning message for PHP. (The bug is a PHP 4.3.1 bug - http://bugs.php.net/bug.php?id=30900&edit=1). However I put a workaround for everybody.

version 2.0

* Added ProPlayer button to WordPress default post editor toolbar
* Added ProPlayer quicktag to the HTML view
* Added support for multiple video in one post
* Some problematic dailymotion, youtube video resolution have been fixed.

version 1.6

* Added preview image support for Youtube, Vimeo and Veoh
* Default preview image support
* Some minor bugs are fixed

version 1.5

* Added 26 new skins [Stylish v1.1 (Default), Blue Metal, Grunge Tape, 3D Pixel Style, Atomic Red, Overlay, Comet, Control Panel, DangDang, Fashion, Festival, Ice Cream Sneaka, Kleur, Magma, Metarby 10, Stylish v1.0, Nacht, Neon, Pearlized, Pixelize, Playcasso, Schoon, Silvery White, Simple, Snel, Stijl, Traganja]
* Added customized skin addition option
* Added Visualizer support for audio files
* Added Rating support for all media files (by Rate it all)
* Added Watermark/Logo support for all media files

version 1.1

* Added options page
* Customizable skin
* Customizable colors
* Customizable default width and height options
* Customizable video stretching options (fill, uniform, exact fit, none)

version 1.0.5

* Usage changed from &lt;pro-player&gt; to [pro-player]
* Some bug fixes

version 1.0

* Initial release

== Limitations ==

* Visuzalizer plugin has known issues by its author. So please don't try on Firefox 3.08 on OSX. There might be problem on other OS/browser combinations. I don't have a list for that. I just know that there is a known issue.

* Ad plugin from Longtail has its own issues. There will be a bug fix release after these guys fix their code-base.

* Unfortunately I didn't implement a perfect ID detection algorithm. So you sometimes have to manually strip the irrelevant tags from the link URL. For example:

instead of:

        http://vimeo.com/2440304&embed=23023492873

you should place:

        http://vimeo.com/2440304

This is not mandatory. However, some videos doesn't work if you don't strip the irrelevant text from the video URL.

* In some cases, the whitespaces before/after link URL can cause some problems. If you don't want any problems, just please pay attention to not use whitespaces before and after the video URL.

* One limitation about playlists. If you have hundreds videos (if files are not hosted by your server) in your playlist, you might have some delay on page loads. For performance-wise, please don't use more than 10-20 items. And if possible, please grab all your videos from same source. No problem with playing, I'm just commenting this to inform you.

* Longtail AdSolutions mid-roll ads are incompatible with visualizer and embedding. So if you turn on embedding/sharing or visualizer you cannot see mid-roll ads. Please make sure that you're using pre-roll or post-roll ads if you wanna turn these options on.

* When you add a RTMP file, make sure that all your playlist contains songs/videos from same server. No mixed playlist allowed!