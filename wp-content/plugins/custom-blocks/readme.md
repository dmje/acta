## Custom Blocks 

Custom Blocks is a simple plugin which allows developers to add ACF Gutenberg blocks in a simple, repeatable and transferrable way. A core principle of the plugin is that blocks are "self-contained", so should include all the markup, CSS, JS, ACF JSON etc. within the block directory.

The plugin has the functionality to support two different types of block:

**Global blocks** are those that you might want to use across multiple sites. So for instance if your clients are always asking for a slider block then you might want to create a global slider block which you can then easily switch on (see below) when the next client asks for it. Global blocks are stored in the *blocks* folder inside the plugin itself. 

We're aiming to build up a useful library of Global blocks over time, so we don't have to keep re-creating the same old functionality / markup.

**Local blocks** are more specific to a particular client/theme/site. So if client asks for a block that is really only ever going to be relevant to them, then there's no point in cluttering up the plugin itself with this. These Local blocks are again created in a *blocks* folder but this time the folder is kept in the theme folder.

It's worth saying that the structure of Local and Global blocks is exactly the same - so you absolutely can transfer between the two. So if a Client 1 asks for specific weird thing X but then all your other clients start asking for the same thing, you could just copy that block from the theme folder of Client 1's site into the plugin and re-use it from there.

### Prerequisites
Custom Blocks requires ACF. What kind of fool would make Gutenberg blocks without it? :-)

### Creating blocks
To create a new block, do this:

* Copy the *_template* folder that is inside the *blocks* folder of the plugin.
* Paste it - either into the *blocks* folder of your theme if it's a **Local block** or in the *blocks* folder of the Custom Blocks plugin if it's a **Global block**.
* Open up the *block* file in your editor of choice and edit as required (see options below). Make the edits you need - the important one is the UUID which has to be unique and should not contain underscores
* Sync the plugin by going to Plugins and click "Sync" under Custom Blocks.
* Now go into your ACF Field Groups screen and create a new Field Group. Under the Location panel, choose "Block" "is equal to" [the Block Title of the block you just made]. 
* Add the fields you need, and save.
* Now you can amend *block.php* in order to fetch and display the fields you've specified.
* If in TMP, make sure you go to Site Settings > Admin Settings > Blocks and check your box is enabled, click update
* Go to the pub and celebrate.

### Block options
The block options map to options in the [`acf_register_block_type` function](https://www.advancedcustomfields.com/resources/acf_register_block_type/).

| Field              | Description                                      | Values     | Notes |
| ------------------ | ------------------------------------------------ | ---------- | ----  |
| `Active`           | Sets whether the block is enabled/disabled. | `true` or `false` | _required_ |
| `UUID`       	     | Not currently implented. Will be the unique ID for the block that can't change. | n/a | _required_ |
| `Title`     	     | The name of the block as visible in the Gutenberg editor and within ACF screens. | i.e. `Testimonial` | _required_ |
| `Description`      | The description of the block as visible in the Gutenberg editor. | i.e. `My testimonial block` | _optional_ |
| `Keywords`         | A comma seperated list of keywords, used to help users find the block. | i.e. `quote,cite` | _optional_ |
| `CSS`		         | A relative path to any CSS files that need to be included. | i.e. `assets/css/testimonial.css` | _optional_ |
| `JS`		         | A relative path to any JS files that need to be included. | i.e. `assets/js/testimonial.js` | _optional_ |
| `Version`          | Not actually sure we need this? | n/a | _optional_ |
| `Post Types`       | A comma seperated list of post types to restrict this block type to. | i.e. `post,page` | _optional_ |
| `Allow Mulitple`   | This property allows the block to be added multiple times. | `true`  or `false` | _optional_ |
