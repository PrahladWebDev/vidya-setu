This was my 5th semester college project.

Vidya Setu — Security Fixes Applied
=================================

1. Password security
   - Passwords are now hashed with password_hash() on registration (add_users.php)
     and verified with password_verify() on login (login.php). Plaintext
     passwords are never stored or compared anymore.

2. SQL injection fixed
   - All raw string-interpolated SQL queries were converted to prepared
     statements with bound parameters: faculty_panel.php, allotment.php,
     regi_list.php, user_data_fill.php, my_submissions.php, view_person_data.php.

3. Centralized DB connection
   - Removed repeated hardcoded "root" / no-password connection blocks from
     login.php, allotment.php, get_schools.php. Every page now uses the
     single connection defined in database.php.

4. Missing access control fixed
   - add_users.php, allotment.php, regi_list.php, admin_data_report.php,
     test.php had NO login check at all — anyone with the URL could view or
     modify data. They now require an active admin session.

5. File cleanup / renaming
   - dummy.php     -> faculty_dashboard.php   (faculty landing page)
   - dummy2.php    -> my_submissions.php      (faculty's submitted reports)
   - dummy3.php    -> view_person_data.php    (admin: view one person's data)
   - droptest.php removed (unused prototype, superseded by allotment.php)
   - test.php kept and wired into the admin sidebar as "Stats"
   - All broken internal links (display_data.php, view_persons.php,
     search-vehicle.php) fixed to point to the correct existing pages.

6. Basic output escaping
   - Wrapped database values echoed into HTML with htmlspecialchars() to
     reduce stored-XSS risk on pages that display faculty/admin-entered data.

IMPORTANT — first-time setup
-----------------------------
Because add_users.php now requires an admin to be logged in, there's no
account yet the first time you set this up. Create your first admin
manually in the database, e.g. run this in phpMyAdmin/MySQL (replace the
values), where the password hash below is for "admin123" — generate your
own with PHP's password_hash():

  INSERT INTO usersss (name, department, role, username, password)
  VALUES ('Admin', 'Admin', 'admin', 'admin@example.com',
          '$2y$10$examplehashreplacewithrealone');

To generate a real hash, run this once from a PHP file or CLI:
  echo password_hash('your_password_here', PASSWORD_DEFAULT);

Still recommended (not done here, out of scope for this pass):
- CSRF tokens on all forms
- Server-side input validation (dates, emails, required fields)
- Move DB credentials out of database.php into environment variables
