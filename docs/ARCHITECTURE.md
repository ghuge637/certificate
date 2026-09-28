# System Architecture & Technical Specifications

## Architectural Layers

```
 [ Web Browser / Client ]
            │
            ▼
 ┌─────────────────────────────────────────┐
 │        AuthController (Spring MVC)      │
 ├─────────────────────────────────────────┤
 │     Authentication & UI Controller     │
 └────────────────────┬────────────────────┘
                      │
                      ▼
 ┌─────────────────────────────────────────┐
 │          AuthService (Service)          │
 ├─────────────────────────────────────────┤
 │   Validates Credentials & Roles         │
 └────────────────────┬────────────────────┘
                      │
                      ▼
 ┌─────────────────────────────────────────┐
 │         Domain Models & DTOs            │
 ├─────────────────────────────────────────┤
 │ User, Role (STUDENT, STAFF), LoginReq   │
 └─────────────────────────────────────────┘
```

## Security & Role Management
- **STUDENT Role**: Granted access to `/dashboard/student` to view personal certificates and apply for new certificates.
- **STAFF Role**: Granted access to `/dashboard/staff` to manage pending approvals, issue new certificates, and view statistics.
