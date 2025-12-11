# EcoShare Skeleton (Backend + Freelancer front + Gentelella admin)

This project is based on your EcoShare modern UI backend, but the templates have been replaced with:

- **Front office**: Freelancer (StartBootstrap), integrated under:
  - `public/front/...`
  - `templates/user/base_user.html.twig`
  - `templates/user/home.html.twig`
  - `templates/user/security/login.html.twig`
  - `templates/home.html.twig`

- **Admin**: Gentelella admin template, integrated under:
  - `public/admin/build`, `public/admin/vendors`
  - `templates/admin/layout.html.twig`
  - `templates/admin/dashboard.html.twig` (and other admin templates that extend this layout)

Extra entities skeletons added in `src/Entity`:
  - User, ObjectItem, Reservation, Review, Complaint, Recommendation, Event, Sponsor
  (currently only with an id field; you can extend them for your CRUD tasks)

Security is configured with in-memory users (admin/user) for testing and routes:
  - `/` → front (Freelancer)
  - `/auth/login` → Symfony Security login (Freelancer-styled)
  - `/admin/...` → protected by ROLE_ADMIN (Gentelella admin layout)

You can now:
  - Implement your CRUD logic in controllers and entities.
  - Pass data to Twig templates (Freelancer / Gentelella) using loops and blocks.
