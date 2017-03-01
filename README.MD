# LearnDash Quiz Hooks Generator

LearnDash Quiz Hooks Generator is a LearnDash addon which facilitates to create custom hooks for LearnDash Quiz, these custom hooks could be used by developers to easily customize and extend the capabilities of LearnDash Quiz. It can serve as the missing piece for the hooks which are not available in the default LearnDash installation and could help to meet client specific requirements without core hacking of LearnDash.

Navigate here,
`wp-content/plugins/sfwd-lms/includes/vendor/wp-pro-quiz/lib`

All the files inside this directory can be overridden and used to add the custom hooks, you will have to place the files with the same directory structure here,

`wp-content/plugins/learndash_quiz_hooks_generator/lib`

To get started, one custom hook is already created through this addon, more can be created by developers according to their specific needs. See the sample **WpProQuiz_Model_QuestionMapper.php** file insde the model folder in the above path, you will have to just follow the same approach to override any other file. 

As soon as you place the file correctly, the files placed inside the hook generator plugin will be loaded instead of the default LearnDash file. You can now modify the file to create your own hooks. 
Notice the sample hook **"learndash_quiz_questions"** inside the file 
`wp-content/plugins/learndash_hooks_generator/lib/model/
WpProQuiz_Model_QuestionMapper.php` as an example.

A custom filter is already created with the plugin install. You will be able to modify the quiz questions displayed in LearnDash Quiz using this custom filter. This wasn't possible by default, as LearnDash provides no hook for this.

After plugin install, you can use this filter anywhere now,

```
add_filter("learndash_quiz_questions", function( $quiz_data ) {});
```
`$quiz_data holds quiz questions to be displayed in your LearnDash Quiz you can alter them according to your specific development needs through this hook.`

# #Installation

Before installation please make sure you have latest LearnDash installed.

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress