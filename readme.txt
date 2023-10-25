=== VK Filter Search ===
Contributors: vektor-inc,kurudrive,rickaddison7634,naoki0h,mimitips,una9,sysbird,chiakikouno
Donate link:
Tags: Guternberg, Search
Requires at least: 6.0
Tested up to: 6.3
Requires PHP: 7.4
Stable tag: 2.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to add a search function as a block to narrow down your search by category, tag, custom post type, keyword, etc.

== Description ==
This is the Filter & Search plugin for WordPress compatible with Gutenberg Block Editor.
This plugin makes it easy to put search box anywhere on your WordPress website.
If you have custom post type, you can also narrow down the search by custom post types.

[youtube https://youtu.be/PbtQB58CPYM]

= Add Filter Function =
Site visitors can search your posts by filtered category, tag, custom post type, keyword, etc.
You can see the documentation [on our website](https://vk-filter-search.com/).

= 4,000+ Active installations =
Since its release in November 2020, it has been installed on many websites.

= Block Editor Support =
You can easily place the search box as a block. No coding in PHP etc is required.

= Easy to Use =
With this plugin, you can create the Filter Search Block on your edit screen.
If you have custom post types, you can also narrow down the search by custom post types.

## Features
* Block editor support
* Taxonomy search (category, tag, custom taxonomy)
* Keyword search
* Specify the target post type (post, page, custom post type)
* Insert form in search result page
* Display on post archive page

= Pro Version =
Pro Version has a Wide Range of Features!
* Post Date Search Block
* Search Result Single Order
* Custom Field Search (beta)
* Check Boxes or Radio Buttons are also available for selection
* AND/OR search settings for checkbox selection
* When using Taxonomy Search Block, the “Post Counts” can be displayed
* When using Taxonomy Search Block, terms with no postings can be displayed
* Block width settings for each screen size
* Editable text for labels (item names)
* Editable text for search buttons
Find out about additional features of VK Filter Search Pro [on our website](https://vk-filter-search.com/).

== Installation ==

This plugin can be installed directly from “Plugins” in your WordPress dashboard.

1. Upload the entire "vk-filter-search" folder to the /wp-content/plugins/ directory, or install the plugin through your WordPress ‘Plugins’ screen directly. Then activate the plugin through the ‘Plugins’ menu on your WordPress dashboard.
2. Type '/filter' on the edit screen and the VK Filter Search Block will appear in the suggested list.
3. If you select “VK Filter Search” from the suggested list, some preset blocks are inserted to edit the area. Taxonomy Search Block (Set to Category) / Taxonomy Search Block (Set to Tag) / Keyword Search Block / Search Button Block are inserted as preset blocks.
4. You can change the setting of the block. (e.g. the taxonomy to target, the order of the blocks)

== Frequently Asked Questions ==

= Is it compatible with various themes? =
Basically, it's supposed to work fine with any themes. However, there may be some visual design issues mainly related to CSS. It may cause display problems.

= Does the layout of the search results page change on the different themes? =
Yes, the layout of the search results depends on the theme. The search results page and the ability to control the layout of the search results page provided by each theme make such a difference.

= How many labels (item names) can I set? =
Items are placed in blocks, so there are no limitations on the numbers. However, you can set only one label per search item (e.g. category).

= Can it search the post content? =
Yes, users can search the content field of the posts with the Keyword Search Block.

= Is it possible to use checkboxes or radio buttons? =
Users can use checkboxes and radio buttons with the Pro version.
Please check out the feature [comparison between the free and pro versions](https://vk-filter-search.com/docs/free-vs-pro-features-comparison/).

= Which languages are available? =
It is currently available in English and Japanese.
More languages will be added in the future. If you would like to help with translation, please click on the link below to join the contribution.
[Translating WordPress](https://translate.wordpress.org/projects/wp-plugins/vk-filter-search/)

== Screenshots ==

1. Editor View
2. List View
3. Display this form on your search result page
4. Search Results page

== Changelog ==

= 2.3.2 =
[ Bug fix ] Fix XSS.

= 2.3.1 =
Change test version

= 2.3.0 =
[ Add function ] Added a minimum width specification to the column width setting method.
[ Bug fix ][ Call filter search block ] Fixed the display issue with the edit button.
[ Bug fix ] Fixed an issue where the post type archive form was displayed on the search results screen.

= 2.2.3 =
[ Add function ][ Taxonomy ( Pro ) ] Add Setting of auto post counts when the form will be submited.
[ Specification Change ] Forms on Posts with statuses other than private and publish and future will not display on post-type-archive screen and search-result screen.
[ Bug fix ] We have fixed the error that occurred when placing it on the widget screen.

= 2.1.1 =
[ Other ] Version only

= 2.1.0 =
[ Add function ] Add Setting of Direct search ( Auto Submit ) that when you change pulldown or checkbox or radio-button, the form will be submited.
[ Specification Change ] Force load javascript for redirection on header.
[ Specification Change ] Allow heading tag on the form of search result or post type archive screen.

= 2.0.6 =
[ Bug fix ] Allow Inline Style on Search Result Form and Post Type Archive form.

= 2.0.5 =
[ Bug fix ] Fix no Filter Search Post Type Error

= 2.0.0 =
[ Add function ] Add Filter Search post type and add block that call post of Filter Search post type.
[ Bug fix ] Fixed the style of checkboxes and radio buttons so that the last item is to the left.
[ Bug fix ][ Taxonomy ( Pro Only )] Fix the behavior of "Choose filter setting".

= 1.14.3 =
[ Bug fix ] Fix submit button font size setting.

= 1.14.2 =
[ Bug fix ] Allow button's style when html escaped.

= 1.14.1 =
[ Bug fix ] Allow i tag when html escaped.

= 1.14.0 =
[ Add Setting ][ Pro ] Add submit button style setting.

= 1.13.2 =
[ Specification Change ][ Checkbox / Radio ( Pro Only )] Remove unnecessary id in input tag
[ Bug fix ] Delete undeletable form data.
[ Bug fix ] When curent screen is site-editor or widget-editor, delete setting for display search form on search result screen or post-type-archive screen.

= 1.13.1 =
[ Specification Change ] Change Version Only.

= 1.13.0 =
[ Add function ][ Search Result Single Order Pro ] Add Outer Column Setting
[ Other ] Lightweight data acquisition process
[ Other ] Fixed XSS vulnerability

= 1.12.1 =
[ Add Setting ][ Pro ][ Taxonomy ] Add "OPTION LABEL FOR NON-SELECTED" Setting for pulldown and radio button
[ Other ] Add PHPUnit Fatal error test
[ Other ] Change require WordPress Version 5.9+
[ Other ] Edit label name tuning
[ Other ] Update Plugin Update Checker 5.0

= 1.11.0 =
[ Add function ][ Pro ][ Taxonomy ] Added a function to let users choose AND search or OR search when checkbox is specified in taxonomy block.
[ Add function ][ Pro ][ Taxonomy ] Add two options show post counts & hide empty terms.

= 1.10.14 =
[ Specification Change ] Change Version Only.

= 1.10.13 =
[ Bug fix ][ Pro ] Fix getting post_meta method.

= 1.10.12 =
[ Specification Change ] Change Version Only.

= 1.10.11 =
[ Bug fix ] Fix WordPress 5.8 Fatal Error

= 1.10.10 =
[ Design bugfix ] Adjusted the width of the text between dates

= 1.10.9 =
[ Bug Fix ] Theme hook array fire at after_theme_setup@10
[ Bug Fix ] Load Blocks on init@11

= 1.10.8 =
[ Bug Fix ] Fix VK Taxonomy Search Block Error ( Free Only ).

= 1.10.3 =
[ Bug Fix ] Corresponds to block widget.
[ Bug Fix ] add patch for WordPress 6.0

= 1.10.2 =
[ Bug Fix ] fix Custom Field Sort of Number and Character.

= 1.10.1 =
[ Bug Fix ] Don't see undefined in empty text fields on the second and subsequent pages of search results.

= 1.10.0 =
[ Add Block ] Add Search Result Single Order Block ( Pro Only )

= 1.9.2 =
[ BugFix ] Fix alert for block themes.

= 1.9.1 =
[ Specification Change ] fix Custom Field Block Choice System. ( Pro Only )
[ Specification Change ] Corresponds to block themes.
[ Design BugFix ] Fix front style when enable block separate loading

= 1.8.1 =
[ bugFix ] Fix submit button style for Free.

= 1.8.0 =
[ Specification Change ] Add second field around text setting
[ Specification Change ] Change 'Do not specify xx' to 'Any'
[ bugFix ] Fix input / option label on search form
[ bugFix ] Fix Custom Field Block Label ( Pro Only )

= 1.7.2 =
[ bugFix ] Fix Archive page icon

= 1.7.1 =
[ bugFix ] Fix Archive page button

= 1.7.0 =
[ Specification Change ] change can use fontawesome html tags in search button

= 1.6.1 =
[ Specification Change ] change version only

= 1.6.0 =
[ Add block ] Add custom field search block ( Beta ) ( Pro Only )
[ bugFix ] Fix Translate ( Free Only )

= 1.5.6 =
[ Specification Change ] change version only

= 1.5.5 =
[ Specification Change ] change version only

= 1.5.4 =
[ Specification Change ] change version only

= 1.5.3 =
[ Specification Change ] change can use fontawesome html tags in label

= 1.5.2 =
[ Deploy ] fix Deployment

= 1.5.1 =
[ Deploy ] fix Deployment

= 1.5.0 =
[ Add Function ] Add Date Filter ( Pro Only )

= 1.4.0 =
[ Add Function ] Add Radio button and check box column control ( Pro Only )
[ Spechification Change ] Change css selector strongth for cope with other theme

= 1.3.4 =
[ bugfix ] Fix script for redirect after search

= 1.3.3 =
[ bugfix ] Fix script for redirect after search

= 1.3.2 =
[ Other ] change version

= 1.3.1 =
[ Other ] Cope with WordPress 5.8

= 1.3.0 =
[ Specification Change ] Change redirect method php to javascript.
[ Specification Change ] Change checkbox / radio layout for mobile ( Pro Only )
[ Specification Change ] No need for free version.

= 1.2.0 =
[ Add Function ] Add setting of inner block width.
[ Bug Fix ] Remove unnecessary CSS

= 1.1.5 =
[ Bug Fix ] Fix arguments of functions on block.

= 1.1.4 =
[ Specification Change ] Change Version Only.

= 1.1.3 =
[ Specification Change ] Fix PHP 8.0 Notice of functions.
[ Bug fix ] Fix search results display ul li.

= 1.1.2 =
[ Specification Change ] Change Version Only.

= 1.1.1 =
[ Specification Change ] Fix all blocks of block.json for Block Directory.

= 1.1.0 =
[ Specification Change ] Change icons
[ Bug fix ] Cope with WordPress 5.7

= 1.0.3 =
[ Bug fix ] Fix css class of dropdown on custom taxonopmy.

= 1.0.2 =
[ Bug fix ] Fix Layout bug on Safari (gap)

= 1.0.0 =
[ Specification Change ] Requires at least: 5.6
[ Specification Change ] Use wp_dropdown_categories

= 0.6.5 =
[ Specification Change ] Change script of query.

= 0.6.4 =
[ Bugfix ] If Post type is not selected, result page is not for any post type.

= 0.6.3 =
[ Specification Change ] Change Config file

= 0.6.2 =
[ Specification Change ] Delete needless code

= 0.6.1 =
[ Specification Change ] Config file

= 0.6.0 =
[ Specification Change ] Button design

= 0.5.2 =
[ Bugfix ] If options is empty, Warning is appear

= 0.5.1 =
[ Bugfix ] If options is empty, Warning is appear

= 0.5.0 =
[ Add Function ] Display to post type archive page

= 0.4.21 =
[ Other ] Change Sentence.

= 0.4.20 =
[ Bug fix ] Fix Error.

= 0.4.19 =
[ Other ] Change File Name.

= 0.4.18 =
[ Bug fix ] Try Taxonomy Search Translate

= 0.4.17 =
[ Bug fix ] fix Taxonomy Search Translate

= 0.4.16 =
[ Bug fix ] fix @wordpress/i18n import

= 0.4.15 =
[ Other ] fix fatal error

= 0.4.14 =
[ Other ] bug fix

= 0.4.13 =
[ Other ] build only

= 0.4.12 =
[ Bug fix ] fix translate function and deploy settings

= 0.4.11 =
[ Bug fix ] fix translate function

= 0.4.10 =
[ Other ] build only

= 0.4.9 =
[ Bug fix ] fix translate function

= 0.4.8 =
[ Bug fix ] fix translate function

= 0.4.7 =
[ Bug fix ] fix translate function

= 0.4.6 =
[ Bug fix ] fix translate function

= 0.4.5 =
[ Bug fix ] fix translate function

= 0.4.4 =
[ Bug fix ] fix translate function

= 0.4.3 =
[ Bug fix ] fix translate function

= 0.4.2 =
[ Bug fix ] delete translate file

= 0.4.1 =
[ Bug fix ] Query bug fix

= 0.4.0 =
[ Specification Change ] Change logic of display the search box to search result page.

= 0.3.2 =
[ Bug fix ] fix console error.

= 0.3.1 =
[ Specification Change ] padding and margin tuning

= 0.3.0 =
[ Specification Change ] padding and margin tuning

= 0.2.3 =
[ Other ] Rebuild only

= 0.2.2 =
[ Bug fix ] fit syntax error

= 0.2.1 =
[ Bug fix ] fit syntax error

= 0.2.0 =
[ Add function ] Can be add search form in result page.

= 0.1.0 =
* Initial release.