# Student Features Testing Guide

## Quick Test: Verify Everything Works

### 1. Login as Student
```
URL: http://localhost:8000/login
Email: alice@student.com
Password: password
```

### 2. View Opportunities
```
Navigate to: Dashboard → Find Opportunities
OR: http://localhost:8000/student/opportunities
```

**✅ Should See:**
- List of approved opportunities
- Search bar and type filter
- Organization names displayed
- Deadlines shown

### 3. Test Search
```
1. Enter "Software" in search box
2. Click Search
```

**✅ Should See:**
- Filtered results matching "Software"

### 4. Test Filter
```
1. Select "Internship" from dropdown
2. Click Search
```

**✅ Should See:**
- Only internship opportunities

### 5. View Details
```
1. Click "View Details" on any opportunity
```

**✅ Should See:**
- Full opportunity description
- Organization details
- "Apply Now" button (green)

### 6. Apply for Opportunity
```
1. Click "Apply Now" button
```

**✅ Should See:**
- Success message
- Button changes to "Already Applied" (disabled)

### 7. View Applications
```
Navigate to: Dashboard → My Applications
OR: http://localhost:8000/student/applications
```

**✅ Should See:**
- List of applied opportunities
- Application status

---

## Test Credentials

**Student:**
- Email: `alice@student.com`
- Password: `password`

**Admin (to approve opportunities):**
- Email: `admin@brightfuture.com`
- Password: `password`

**Organization (to create opportunities):**
- Email: `org@techuni.com`
- Password: `password`

---

## Common Issues & Solutions

### Issue: "No opportunities found"
**Solution:** Login as admin and approve pending opportunities at `/admin/opportunities/pending`

### Issue: Can't apply to opportunity
**Check:**
- Is opportunity approved? (admin must approve)
- Is deadline not passed?
- Have you already applied?

### Issue: Search not working
**Solution:** Clear search and try again. Search works on title and description.

---

## All Student Routes

```
GET  /student/dashboard              - Student dashboard
GET  /student/opportunities          - Browse opportunities
POST /student/opportunities/{id}/apply - Apply for opportunity
GET  /student/applications           - View my applications
GET  /student/profile/edit           - Edit profile
PUT  /student/profile                - Update profile
```

---

## Performance Features

✅ **Optimized Queries** - No N+1 problems
✅ **Indexed Searches** - Fast filtering
✅ **Pagination** - 12 opportunities per page
✅ **Eager Loading** - Organizations loaded efficiently
✅ **Efficient Checks** - Using `exists()` for boolean queries

---

## Error Handling

✅ **Missing Organization** - Filtered out automatically
✅ **Duplicate Applications** - Prevented with error message
✅ **Expired Opportunities** - Cannot apply
✅ **Unapproved Opportunities** - Cannot apply
✅ **Helpful Messages** - Clear error feedback
