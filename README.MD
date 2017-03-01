=== LearnDash Quiz Hooks Generator ===
Contributors: wooninjas
Tags: learndash, hooks, quiz, questions, lms, customize-learndash
Requires at least: 4.0
Tested up to: 4.6.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Hooks Generator for LearnDash

== Description ==

LearnDash Quiz Hooks Generator is a LearnDash addon which facilitates to create custom hooks for your LearnDash Quiz, these custom hooks could be used by developers to easily customize and extend the capabilities of LearnDash Quiz. It can serve as the missing piece for the hooks which are not available in the default LearnDash installation and may be required by developers to extend the capabilities of LearnDash to meet client specific requirements. The benefit being that It would prevent direct hacking of core LearnDash files to customize the behavior according to your specific needs.

Navigate here,
wp-content/plugins/sfwd-lms/includes/vendor/wp-pro-quiz/lib

All the files inside this directory can be overridden and can be used to add the custom hooks required by the developer, you will have to place the files with the same directory structure here,

wp-content/plugins/learndash_quiz_hooks_generator/lib

To get started, one custom hook is already created through this addon, more can be created by developers according to their specific needs. See the sample WpProQuiz_Model_QuestionMapper.php file insde the model folder in the above path, you will have to just follow the same approach to override any other file. 

As soon as you place the file correctly, the files placed inside the hook generator plugin will be loaded instead of the default LearnDash file. You can now modify the file to create your own hooks. See the sample hook "learndash_quiz_questions" inside the file wp-content/plugins/learndash_hooks_generator/lib/model/WpProQuiz_Model_QuestionMapper.php as an example.

As an example, a custom filter has been created as soon as you install the plugin. You will be able to modify the quiz questions displayed in LearnDash Quiz using this custom filter.

This wasn't possible by default, as LearnDash provides no hook for this.

after plugin install, you can use this filter anywhere in WP

```
add_filter("learndash_quiz_questions", function( $quiz_data ) {});
```
`$quiz_data holds quiz questions to be displayed you can alter them according to your specific development needs`

== Installation ==

Before installation please make sure you have latest LearnDash installed.

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Changelog ==
= 1.0.0 =
* Initial
