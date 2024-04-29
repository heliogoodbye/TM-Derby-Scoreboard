# TM Derby Scoreboard

![TM Derby Scoreboard](https://github.com/heliogoodbye/TM-Derby-Scoreboard/assets/105381685/5b10636e-e1e7-4b46-8608-9d48f5bd404d)

**TM Derby Scoreboard** is a WordPress plugin designed to manage and display roller derby game scores. It extends WordPress by introducing a custom post type called "game-score" to store information about individual roller derby games, including the date of the game, venue, location, teams involved, and their respective scores.

Key features of the plugin include:

- **Custom Post Type:** The plugin introduces a custom post type named "game-score" to store roller derby game information.
- **Custom Fields:** Within each game post, users can input specific details such as the date of the game, venue, location, team names, and their corresponding scores.
- **Shortcode Integration:** Users can utilize the [derby_scores] shortcode to display game scores on any page or post of their WordPress website. The shortcode offers various attributes to customize the output, including the ability to specify the number of game scores to display, filter by category, specify a particular year, and offset entries.
- **Styling:** The plugin includes a CSS stylesheet, "tm-derby-scoreboard-styles.css," for styling the output of the game scores. Users can enqueue this stylesheet to ensure consistent styling with their WordPress theme.
- **Flexible Display Options:** The plugin offers flexibility in displaying game scores, allowing users to choose between a list or grid layout. Additionally, users can display all games from a specific year or apply an offset to skip a certain number of entries.
- **XML Export:** The plugin has the functionality to export the game scores as an XML document. When the `tm_derby_scoreboard' parameter is set to 'xml' in the URL (example `http://[your site address]/?tm_derby_scoreboard=xml`), the plugin generates an XML document containing the game information.

TM Derby Scoreboard provides an efficient solution for roller derby enthusiasts, leagues, or websites to manage and showcase their game scores in a structured and customizable manner within their WordPress-powered websites.

---

### How to Use TM Derby Scoreboard

To effectively use the "TM Derby Scoreboard" plugin, follow these step-by-step instructions:

1. Installation:
- Download the "TM Derby Scoreboard" plugin from a reliable source or the WordPress plugin repository.

- Log in to your WordPress admin dashboard and navigate to `Plugins > Add New`. Click on the "Upload Plugin" button, choose the plugin ZIP file, and click "Install Now."

- After the installation is complete, activate the plugin from the Plugins page in your WordPress admin dashboard.

2. Adding Game Scores:
- In the WordPress admin dashboard, you'll find a new menu item called "Game Scores." Click on it to add new game scores.

- Click on "Add New" to create a new game score entry. Fill in the required fields such as the date of the game, venue, location, team names, and their respective scores.

3. Displaying Game Scores:
- To display game scores on any page or post, use the `[derby_scores]` shortcode. You can place this shortcode in the WordPress editor of the desired page or post.

- Shortcode Attributes:
   - **`count`**: Specify the number of game scores to display. Default is set to display all (-1).
   - **`year`**: Display game scores from a specific year (optional).
   - **`offset`**: Skip a certain number of entries before displaying the rest (optional).

   Example: `[derby_scores count="5" category="featured" year="2024" offset="2"]`

4. Customization:
- If desired, edit the plugin's stylesheet `css/tm-derby-scoreboard-styles.css` to ensure consistent styling with your WordPress theme.

5. Save and Publish:
- **Preview and Publish**: Preview your page or post to ensure the game scores are displaying correctly. Once satisfied, publish your changes to make the game scores live on your website.

By following these instructions, you'll be able to effectively utilize the "TM Derby Scoreboard" plugin to manage and display roller derby game scores on your WordPress website.

---

## How to use the XML document that the plugin generates

Once you have accessed the XML document generated by the plugin (example `http://[your site address]/?tm_derby_scoreboard=xml`), you can use it in various ways, depending on your needs:

- **Data Import:** You can import the XML data into other systems or applications that support XML import. For example, if you have a custom web application or another CMS, you can import the data to populate roller derby game scores.
- **Data Analysis:** If you want to analyze the roller derby game scores data, you can parse the XML document using programming languages like Python, PHP, or JavaScript. Once parsed, you can perform various analyses, such as calculating average scores, identifying trends, or generating reports.
- **Display:** If you have another website or platform where you want to display the roller derby game scores, you can parse the XML document and render the data according to your desired format. This could involve creating custom templates or scripts to display the scores in a visually appealing way.
Integration: You can integrate the XML data with other plugins, themes, or systems within WordPress itself. For example, you could create custom templates or shortcodes to display the game scores in different parts of your WordPress site.
- **Backup and Archiving:** You can use the XML document as a backup or archive of your roller derby game scores data. If you ever need to restore or retrieve the data in the future, you can refer to the XML document for the historical records.
- 
Overall, the XML document provides a structured format for accessing and manipulating the roller derby game scores data generated by the plugin, offering flexibility for a variety of uses.
