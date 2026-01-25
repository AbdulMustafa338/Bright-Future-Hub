# Admin Panel Access & Review Guide

## Quick Access

### Admin Login Credentials
- **URL:** http://localhost:8000/login
- **Email:** admin@brightfuture.com
- **Password:** password

### First Time Setup
```bash
# Run database seeder to create admin account
php artisan db:seed
```

---

## Admin Panel Routes

| Feature | URL | Description |
|---------|-----|-------------|
| Dashboard | `/admin/dashboard` | Overview statistics |
| All Users | `/admin/users` | Manage all users |
| All Opportunities | `/admin/opportunities` | View all opportunities |
| Pending Opportunities | `/admin/opportunities/pending` | Review pending opportunities |
| Organization Details | `/admin/organizations/{id}` | View organization profile |

---

## Review Workflows

### 1. Review Organization Account

**When:** New organization registers

**Steps:**
1. Login as admin
2. Navigate to `/admin/users`
3. Find the organization user
4. Click to view organization details
5. Review organization profile:
   - Organization name
   - Description
   - Contact person
   - Status (pending/approved/rejected)
6. Toggle account status if needed (activate/deactivate)

**Note:** Organization profile status is separate from user account status.

---

### 2. Review & Approve Opportunities

**When:** Organization posts a new opportunity

**Steps:**
1. Login as admin
2. Navigate to `/admin/opportunities/pending`
3. Review opportunity details:
   - Title
   - Description
   - Eligibility criteria
   - Type (scholarship/internship/job/admission)
   - Deadline
   - Application link
4. **To Approve:**
   - Click "Approve" button
   - Opportunity becomes visible to students
5. **To Reject:**
   - Click "Reject" button
   - Enter rejection reason
   - Organization receives feedback

---

## Admin Capabilities

### User Management
- ✅ View all users (students, organizations, admins)
- ✅ Activate/Deactivate user accounts
- ✅ View user details and activity
- ✅ Cannot delete admin users

### Opportunity Management
- ✅ View all opportunities (approved, pending, rejected)
- ✅ Approve pending opportunities
- ✅ Reject opportunities with reason
- ✅ Filter opportunities by status
- ✅ View opportunity applications

### Organization Management
- ✅ View organization profiles
- ✅ View organization statistics
- ✅ View all opportunities posted by organization
- ✅ Review organization details

### Dashboard Analytics
- ✅ Total users count
- ✅ Students count
- ✅ Organizations count
- ✅ Pending opportunities count
- ✅ Approved opportunities count
- ✅ Total applications count
- ✅ Recent opportunities list

---

## Creating Additional Admin Accounts

### Method 1: Via Tinker
```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin Name',
    'email' => 'admin@example.com',
    'password' => bcrypt('secure-password'),
    'role' => 'admin',
    'is_active' => true
]);
```

### Method 2: Via Database
```sql
INSERT INTO users (name, email, password, role, is_active, created_at, updated_at)
VALUES (
    'Admin Name',
    'admin@example.com',
    '$2y$10$...',  -- Use bcrypt hash
    'admin',
    1,
    NOW(),
    NOW()
);
```

---

## Testing Admin Features

### Test Accounts (from seeder)

**Admin:**
- Email: admin@brightfuture.com
- Password: password

**Organization:**
- Email: org@techuni.com
- Password: password

**Student:**
- Email: alice@student.com
- Password: password

### Test Workflow

1. **Login as Organization**
   - Create a new opportunity
   - Opportunity will be in "pending" status

2. **Login as Admin**
   - Go to Pending Opportunities
   - Approve or reject the opportunity

3. **Login as Student**
   - If approved, opportunity is now visible
   - Student can apply

---

## Security Notes

⚠️ **Important:**
- Change default admin password in production
- Admin accounts cannot be deactivated by other admins
- Only admins can access `/admin/*` routes
- Role-based middleware protects all admin routes

---

## Troubleshooting

**Can't login as admin?**
- Verify admin user exists: `php artisan tinker` → `\App\Models\User::where('role', 'admin')->get()`
- Check password is correct
- Ensure `is_active` is true

**Admin routes not working?**
- Check middleware in `routes/web.php`
- Verify user role is exactly 'admin' (lowercase)
- Clear cache: `php artisan cache:clear`

**Organization not showing in users list?**
- Check if organization profile was created
- Verify user role is 'organization'
- Check database: `SELECT * FROM users WHERE role = 'organization'`
