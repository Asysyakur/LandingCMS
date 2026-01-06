# 🚀 ComPro CMS API - Quick Reference

---

## 📡 Base URL
```
http://127.0.0.1:8000/api
```

---

## 🔑 Authentication

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/register` | ❌ | Register new user |
| POST | `/login` | ❌ | Login user |
| GET | `/profile` | ✅ | Get user profile |
| PUT | `/profile` | ✅ | Update user profile |
| POST | `/change-password` | ✅ | Change password |
| POST | `/logout` | ✅ | Logout user |

**Auth Header:**
```
Authorization: Bearer {token}
```

---

## 📄 Pages Management

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/cms/pages` | ✅ | List all pages |
| POST | `/cms/pages` | ✅ | Create page |
| GET | `/cms/pages/{id}` | ✅ | Get page details |
| PUT | `/cms/pages/{id}` | ✅ | Update page |
| DELETE | `/cms/pages/{id}` | ✅ | Delete page |

---

## 🧩 Components

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/cms/components` | ✅ | List component templates |
| POST | `/cms/pages/{pageId}/components` | ✅ | Add component to page |
| PUT | `/cms/pages/{pageId}/components/{componentId}` | ✅ | Update component content |
| DELETE | `/cms/pages/{pageId}/components/{componentId}` | ✅ | Remove component |

**Available Components:**
- `hero` - Hero Section
- `features` - Features Grid
- `about` - About Us
- `services` - Services/Products
- `testimonials` - Customer Reviews
- `contact` - Contact Information

---

## 📦 Content Versioning

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/cms/pages/{pageId}/versions` | ✅ | List versions |
| POST | `/cms/pages/{pageId}/versions/{versionId}/restore` | ✅ | Restore version |

---

## 📊 Analytics

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/analytics/dashboard` | ✅ | Dashboard stats |
| GET | `/analytics/pages/{pageId}` | ✅ | Page analytics |
| POST | `/analytics/track/{pageSlug}` | ❌ | Track visitor |

**Query Params:**
- `period`: `7days`, `30days`, `90days`, `year` 

---

## 👁️ Preview

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/preview/pages/{pageId}` | ✅ | Preview page (draft) |
| GET | `/preview/pages/{pageId}/responsive` | ✅ | Responsive preview |
| GET | `/preview/components/{componentSlug}/schema` | ✅ | Component schema |
| POST | `/preview/components/{componentSlug}/preview` | ✅ | Component preview |
| GET | `/preview/public/{pageSlug}` | ❌ | Public page view |

**Query Params:**
- `device`: `desktop`, `tablet`, `mobile` 

---

## 📋 Request Body Templates

### Create Page
```json
{
  "title": "Page Title",
  "slug": "page-slug",
  "status": "draft",
  "business_profile": {
    "company_name": "Company Name",
    "logo": "url",
    "phone": "08xxx",
    "email": "email@example.com",
    "address": "Address"
  },
  "metadata": {
    "meta_title": "Meta Title",
    "meta_description": "Meta Description"
  }
}
```

### Add Component
```json
{
  "component_id": "uuid-component-id",
  "content": {
    "title": "Main Title",
    "subtitle": "Subtitle",
    "cta_text": "Button Text",
    "cta_link": "https://..."
  },
  "order_index": 0
}
```

### Update Component
```json
{
  "content": {
    "title": "Updated Title",
    "subtitle": "Updated Subtitle"
  },
  "order_index": 0,
  "is_active": true
}
```

### Track Visitor
```json
{
  "fingerprint": "unique-id",
  "referrer": "https://..."
}
```

---

## 🎨 Response Format

### Success (200/201)
```json
{
  "status": true,
  "message": "Success message",
  "data": { ... }
}
```

### Error (400/401/404/422)
```json
{
  "status": false,
  "message": "Error message",
  "errors": { ... }
}
```

---

## 🔄 Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Success |
| 201 | Created - Resource created |
| 204 | No Content - Success, no content returned |
| 400 | Bad Request - Invalid request |
| 401 | Unauthorized - Auth required |
| 403 | Forbidden - No permission |
| 404 | Not Found - Resource not found |
| 422 | Validation Error - Invalid data |
| 500 | Server Error - Internal error |

---

## 💡 Quick Commands

### Start Server
```bash
php artisan serve
```

### Test with cURL
```bash
# Login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123"}'

# Get Pages (with token)
curl -X GET http://127.0.0.1:8000/api/cms/pages \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📱 Common Workflows

### 1. Create Landing Page
```
Register → Login → Create Page → Add Components → Publish
```

### 2. Edit Existing Page
```
Login → Get Page → Update Components → Create Version → Publish
```

### 3. Rollback Changes
```
Login → List Versions → Restore Version → Publish
```

### 4. View Analytics
```
Login → Dashboard Stats → Page Analytics
```

---

## 🧪 Testing Checklist

### Authentication
- [ ] Register new user
- [ ] Login with valid credentials
- [ ] Get user profile
- [ ] Update profile
- [ ] Change password
- [ ] Logout

### Pages
- [ ] List all pages
- [ ] Create new page
- [ ] Get page details
- [ ] Update page
- [ ] Delete page

### Components
- [ ] List component templates
- [ ] Add component to page
- [ ] Update component
- [ ] Remove component

### Versioning
- [ ] List page versions
- [ ] Restore version

### Analytics
- [ ] Get dashboard stats
- [ ] Get page analytics
- [ ] Track visitor

### Preview
- [ ] Preview page (auth)
- [ ] Get responsive preview
- [ ] Get component schema
- [ ] Get component preview
- [ ] Public page view

---

## 🔧 Environment Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `base_url` | API base URL | `http://127.0.0.1:8000` |
| `access_token` | JWT authentication token | `eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...` |
| `page_id` | Current page ID | `123e4567-e89b-12d3-a456-426614174000` |
| `component_id` | Current component ID | `123e4567-e89b-12d3-a456-426614174001` |
| `version_id` | Current version ID | `123e4567-e89b-12d3-a456-426614174002` |

---

## 📝 Component Schemas

### Hero Component
```json
{
  "title": "string",
  "subtitle": "string",
  "background_image": "string (url)",
  "cta_text": "string",
  "cta_link": "string (url)"
}
```

### Features Component
```json
{
  "section_title": "string",
  "section_subtitle": "string",
  "items": [
    {
      "icon": "string",
      "title": "string",
      "description": "string"
    }
  ]
}
```

### About Component
```json
{
  "title": "string",
  "description": "string (html)",
  "image": "string (url)",
  "stats": [
    {
      "number": "string",
      "label": "string"
    }
  ]
}
```

### Services Component
```json
{
  "section_title": "string",
  "section_subtitle": "string",
  "items": [
    {
      "image": "string (url)",
      "title": "string",
      "description": "string",
      "price": "string"
    }
  ]
}
```

### Testimonials Component
```json
{
  "section_title": "string",
  "items": [
    {
      "photo": "string (url)",
      "name": "string",
      "role": "string",
      "quote": "string",
      "rating": "number (1-5)"
    }
  ]
}
```

### Contact Component
```json
{
  "section_title": "string",
  "address": "string",
  "phone": "string",
  "email": "string",
  "maps_embed": "string (html)",
  "show_contact_form": "boolean"
}
```

---

**Print this page for quick reference! 📄**

Last Updated: January 6, 2026
Version: 1.0.0
