# Graphic Editor

 The service has to be able to draw geometric shapes (circle, square, rectangle, ellipse, etc). 
 
 ##Setup
 - `composer install`
 - `yarn install`
 - `yarn encore dev`
 - `php bin/console server:run`
 
 ##Web interface
go to this localhost url `http://localhost:8000/` which open the main page.
inside this page we can add circle or square (or other shapes), then u have to add them to the cache by clicking
+ button. At the end you cn draw the shapes.

 ##Execute CLI
 type this command  `php bin/console editor:draw-shapes`, then choose the options (add, delete , draw).
then you can choose a shape (circle, square). after choosing a shpae you have to fill values of parameter.
 (`here I disabled the validaiton`)
 
 ##Test
 - `php bin/phpunit`
 ##Implementation
 - EditorController
 Responsible for receiving REST Api requests and call the editor service. 
 in addition, it displays the main page of editor
  - Models
   We have here the shapes and the factory. Each shape extends AbstractShape class which implements an interface
   - Service
   Editor is the min service which manipulates shapes.
   DrawShape draws the shapes.
   ShapeList is our cache data.
   Validation to validate shapes (I am using annotation constraints validation, we can extends this validation).
##Adding a new shape
it is simple and does not need a lot of code.

    - Add the shape class to the models
    - Extend this clas from AbstractShape
    - Add the prameters with annotation validtions
    - Set the parameters
    - Implement getParameters to registers the parameters
    - Implements draw function
##Improvements
    - Make twig more extendable by using generic twig for adding shape
    - Improve the desing style
    

   
   
   
 
 