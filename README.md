# File-management-system
This is a project where me and my colleagueOmar Fustok experienced a new level of non functional requrement that is really important to when it comes to the real application release
We worked with two new design patterns called 3 tiers and AOP
The project idea is simple, a user can upload files on a group, after the admin of the group accept the file, other users can edit this file by check-in the file so it be reserved for them till they are done editing, once the user is done working on the file he can check-out the file and upload a new version of the file to the group
after the check-out proccess the file will be available to anyone to check-in it
the problem that we solved is the concurrent access on check-in, where the file can only be checked-in by one user at a time, we had to solve that issue during this project
We also managed to log all the operations that were done on the project -with the help of AOP design pattern-


Note: During the execution proccess, we were working on a private GitLab repository, the project took less than 2 months -besides the other colleges' projects that we were working on at the same period-
