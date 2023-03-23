
# Mise En Place
___
is a revolutionary web application designed specifically for the restaurant industry. It offers a comprehensive solution for managing and accessing recipes, both for preparation and service, directly from a desktop web browser, or from a mobile device. This innovative app streamlines the recipe management process, providing restaurateurs with an effortless way to update, edit, and access their entire recipe database with ease.
# The Authors
___
Thomas Loudon, Sukanvisa Pearyoo, Adam Wise

# Project Requirements
___
1. Separates all database/business logic using the MVC pattern.
* We put all our business logic and database logic in the model folder, we put all our html pages in the views folder, all of our script files are in the JavaScript folder, and our index.php handles all the routes for our controller class.

2. Routes all URLs and leverages a templating language using the Fat-Free framework. Has a clearly defined database layer using PDO and prepared statements.
* We use fat-free extensively and effectively through out the project, our data base layer is in the  model folder

3. Data can be added and viewed.
* We created several forms for the user to use, like create user and create a recipe, the user can then login, and create a recipe if they are a manager. The recipes can be view by navigating to the designanted location or bys earching the name of the recipe.

4. Has a history of commits from both team members to a Git repository. Commits are clearly commented.
* We are committed to making detailed commits. All three partners made many many commits.

5. Uses OOP, and utilizes multiple classes, including at least one inheritance relationship.
* we have 4 classes and 2 inheritance relationships. User is the parent class, and user_manager is the child. as well as recipe is a aparent class and user_select is a child class dependent on the recipe class.

6. Contains full Docblocks for all PHP files and follows PEAR standards.
* Yes

7. Has full validation on the server side through PHP.
* We have many validation functions inside our validate class. Ones to validate the user login information, as well as user creation, making sure that usernames are unique and passwords are specific to a pattern. Recipes also have requirments, like index must match station, and recipe names cannot have numerical symbols.

8. All code is clean, clear, and well-commented. DRY (Don't Repeat Yourself) is practiced.
* You can be the judge of that but we beleive the code is beautiful.

9. Your submission shows adequate effort for a final project in a full-stack web development course.
* Our project is perfect.

10. BONUS:  Incorporates Ajax that access data from a JSON file, PHP script, or API. If you implement Ajax, be sure to include how you did so in your readme file.
 ·       Your most current UML class diagram
 ·       Your admin login username and password, if applicable
*  We did not do the Bonus
![](../../../recipe diagram.jpg)![](../../../recipe-userSelectDiagram.jpg)![](../../../DatabaseRelationships.png)