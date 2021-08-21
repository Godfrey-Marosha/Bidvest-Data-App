# Bidvest-Data-App
A command line application that simulates a student management console allowing the user to add, edit, delete and search students within the system.

# How to run the application:
Command line or terminal run: php run.php
# Application operators:
php run.php --action=add    
php run.php --action=edit --id=1234567  
php run.php --action=delete --id=1234567    
php run.php --action=search 

# Enter search criteria:
name=Godfrey    

# The application must meet the following requirements:
•	Make use of OOP with the latest standards.      
•	All input (including arguments) must be validated and output formatted as human readable.       
•	Actions must be passed to the application as arguments.     
•	Add a new student (--action=add):       
        o	User must be prompted to enter student id, name, surname, age and curriculum.       
        o	Student ids must be unique and consist of 7 digits.     
        o	All student details are mandatory.      
        o	Student details must be saved in JSON file and stored under a subdirectory starting with the first two digits of the student id (e.g. project_dir/students/12/1234567.json).        
•	Edit an existing student (--action=edit --id=1234567):      
        o	Student must be identified by student id for editing.       
        o	User must be prompted to enter name, surname, age and curriculum.       
        o	User must be allowed to keep existing values without re-entering.       
        o	Student id cannot be changed.       
•	Delete an existing student (--action=delete --id=1234567):      
        o	Student must be identified by student id for deleting.      
        o	User must receive confirmation after successful delete.     
•	Search for a student (--action=search):     
        o	User must be prompted for the search criteria.      
        o	Students matching search criteria must be displayed in a table format.      
        o	If search value is left blank, all students must be returned.    
