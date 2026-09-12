# Vidya Setu

My first project in my MCA — an admin/faculty portal built to plan, track, and report on a college outreach program that sends faculty/volunteers to visit schools and collect data (student counts, board type, target vs. completed status, etc.).

Built with core PHP + MySQL, vanilla JS/CSS, Bootstrap, and Chart.js — no framework, no build step.

## What it does

**Admin**
- Logs in and lands on a sidebar-based admin panel
- Allots a school-visit task to a faculty member: pick a region, pick schools in that region (loaded dynamically via AJAX), set a target and a visit window
- Views registered users, pending allotments, and submitted visit reports
- Views dashboards/charts (board-type distribution, schools covered) built with Chart.js

**Faculty / User**
- Logs in and sees their assigned visits on a dashboard (joined with region info)
- Fills out a report for a completed visit: schools covered, contact person details, class 10/12 status, topics covered, remarks, data collected
- Submitting a report marks that allotment as `Completed`
- Can view their own past submissions

**Roles**: `admin` and `user`, chosen at login and matched against the `usersss` table.

## Tech stack

- PHP (procedural, `mysqli`)
- MySQL
- Bootstrap 4, Boxicons/Remixicon, Chart.js
- Vanilla JS for the dynamic region → school dropdown (AJAX to `get_schools.php`)

## Project structure (key files)

| File | Purpose |
|---|---|
| `index.php` | Public landing page |
| `login.php` | Login form, role-based redirect (admin/user) |
| `database.php` | Single shared `mysqli` connection used by every page |
| `admin.php` | Admin panel shell/sidebar |
| `allotment.php` | Admin: assign schools/targets to a faculty member |
| `get_schools.php` | AJAX endpoint returning schools for a selected region |
| `faculty_dashboard.php` | Faculty landing page — shows their allotments |
| `faculty_panel.php` | Faculty: submit a visit report for an allotment |
| `my_submissions.php` | Faculty: view their own submitted reports |
| `pending.php` | Faculty: view pending (not-yet-completed) allotments |
| `regi_list.php` | Admin: list of registered users |
| `admin_data_report.php` / `view_person_data.php` | Admin: view collected person/report data |
| `board_charts.php` / `data_colected_chart.php` / `total_school_covered_chart.php` | Chart.js dashboards |
| `add_users.php` | Admin: register a new faculty/admin account |
| `test.php` | Admin: quick stats (pending/completed/total allotments) |

## Database

The app expects a MySQL database (default name `erps` in `database.php`) with these tables:

- `usersss` — accounts: `id`, `name`, `department`, `role` (`admin`/`user`), `username`, `password` (hashed)
- `regions` — `region_id`, `region_name`
- `schools` — `school_name`, `region_id`
- `faculty_data` — an allotment: `id`, `user_id`, `department`, `name`, `region_id`, `schools`, `target`, `tsdate`, `tedate`, `status` (`Pending`/`Completed`)
- `faculty_fill_data` — a submitted visit report: `user_id`, `name`, `department`, `target`, `tsdate`, `tedate`, `schools`, `date`, `pname`, `pcont`, `tgtname`, `tgtcont`, `pgtname`, `pgtcont`, `school_status`, `ten`, `twelve`, `topic_covered`, `visit_remark`, `data_collected`

No `.sql` schema file is included in this repo — recreate the tables above (with sensible column types) before running the app.

## Setup

1. Create a MySQL database and the tables listed above.
2. Update the connection details in `database.php` if needed (defaults to `localhost` / `root` / no password / `erps`).
3. Create your first admin account directly in the database, since account creation itself requires being logged in as an admin:
   ```sql
   INSERT INTO usersss (name, department, role, username, password)
   VALUES ('Admin', 'Admin', 'admin', 'admin@example.com', '<hash>');
   ```
   Generate `<hash>` with:
   ```php
   echo password_hash('your_password_here', PASSWORD_DEFAULT);
   ```
4. Serve the folder with PHP (e.g. `php -S localhost:8000`) or drop it into your Apache/XAMPP `htdocs`.
5. Open `login.php`, log in as admin, and start adding faculty accounts and allotments.

## Security notes

This was originally a plain college assignment; it's since had a pass of basic hardening applied (see `FIXES_README.txt` for the full list):

- Passwords are hashed (`password_hash`/`password_verify`), not stored in plain text
- All queries converted to prepared statements
- Pages that previously had no login check now require an authenticated session
- Output escaped with `htmlspecialchars()` where user/faculty-entered data is displayed

Still out of scope: CSRF tokens, server-side input validation, and moving DB credentials out of `database.php` into environment variables.

## Status

This was my 5th-semester MCA college project — not actively maintained, but kept here as an early full-stack milestone.
