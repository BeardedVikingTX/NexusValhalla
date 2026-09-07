# ⚡ NexusValhalla · The Digital Realm of the Einherjar ⚡

[![GitHub release](https://img.shields.io/github/v/release/beardedviking/nexusvalhalla?style=flat-square&logo=github&color=gold)](https://github.com/beardedviking/nexusvalhalla/releases)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Security Audit](https://img.shields.io/badge/Security-A%2B%20Ready-brightgreen?style=flat-square&logo=shield&color=00d4ff)](https://hackerone.com)
[![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square&logo=opensourceinitiative&logoColor=white)](LICENSE)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen?style=flat-square&logo=git&logoColor=white)](https://github.com/beardedviking/nexusvalhalla/pulls)
[![Deployed on NameCheap](https://img.shields.io/badge/Deployed-NameCheap%20Stellar-orange?style=flat-square&logo=namecheap&logoColor=white)](https://namecheap.com)
[![AI Experiment](https://img.shields.io/badge/AI%20Experiment-5%20LLMs%20in%20Battle-purple?style=flat-square&logo=openai&logoColor=white)](#-the-great-ai-llm-experiment)

---

## 🌌 Table of Contents

- [The Saga Begins](#-the-saga-begins)
- [Features of the Realm](#-features-of-the-realm)
- [Tech Stack – The Forge](#-tech-stack--the-forge)
- [Security – The Unbreakable Runes](#-security--the-unbreakable-runes)
- [Admin Dashboard – The All-Seeing Eye](#-admin-dashboard--the-all-seeing-eye)
- [The Great AI LLM Experiment](#-the-great-ai-llm-experiment)
- [Deployment on NameCheap Stellar](#-deployment-on-namecheap-stellar)
- [Contributing – Join the Warband](#-contributing--join-the-warband)
- [VDP & HackerOne – Forge the Shieldwall](#-vdp--hackerone--forge-the-shieldwall)
- [License & Skål](#-license--sk%C3%A5l)

---

## 🛡️ The Saga Begins

**NexusValhalla** is not just another social network – it is a **digital longship** sailing the cosmic seas where the fierce spirit of the Vikings meets the boundless imagination of Sci‑Fi.

> *“In the great hall of the fallen, warriors share tales across galaxies. Now, that hall lives in the cloud.”*

Born from a fusion of *Star Wars*, *Star Trek*, *Stargate*, *Rick & Morty*, and *Vikings*, this platform is built for those who crave community, reputation, and adventure. Every post, every message, every friendship request is an epic rune carved into the fabric of the internet.

---

## ⚔️ Features of the Realm

| Feature | Description |
|:--------|:------------|
| **Free vs Premium** | Unlock the core experience for free; ascend to Valhalla-tier with premium badges, extra storage, and exclusive cosmic themes. |
| **Reputation & Badges** | Earn XP, climb the ranks from *Thrall* to *Jarl*, and collect limited‑edition event badges. |
| **Friend Requests** | Forge alliances with a single click – manage followers and trusted companions. |
| **Posts & Comments** | Share your thoughts across the Nine Realms; threaded comments keep the conversation flowing. |
| **Instant Messaging** | Private 1:1 chats and encrypted group conversations – real‑time, secure, and fast. |
| **Heavy Encryption** | Every byte is AES‑256 encrypted *before* it ever touches the database. Zero‑plaintext storage. |
| **Custom Logging** | Track who, when, and where – detailed audit logs for security and analytics (GDPR‑compliant). |
| **Admin Nexus** | A bespoke admin panel with at‑a‑glance metrics: new users, post velocity, server health, and more. |

---

## 🔧 Tech Stack – The Forge

We wield the finest digital metals:

- **Backend** – PHP 8.2+ (pure OOP, PDO prepared statements)
- **Frontend** – HTML5, CSS3, JavaScript (ES6), AJAX / DOM manipulation
- **Framework** – Bootstrap 5 for responsive, mobile‑first design
- **Icons & Fonts** – Font Awesome 6 + Google Fonts (*Orbitron* & *Cinzel* for that futuristic‑Viking vibe)
- **Database** – MySQL 8.0 (InnoDB, foreign keys, full‑text search)
- **Realtime** – AJAX polling with fallback to WebSocket‑ready architecture
- **Encryption** – OpenSSL (AES‑256‑GCM) + bcrypt for password hashing

---

## 🔐 Security – The Unbreakable Runes

We take security as seriously as a berserker takes his axe.

- All user data (messages, posts, private metadata) is encrypted **client‑side** before transmission, then re‑encrypted server‑side before persistence.
- Strict CSP headers, X‑Frame‑Options, and HSTS enforced.
- Rate limiting on login, messaging, and friend requests to thwart brute‑force.
- Prepared statements everywhere – zero SQL injection vectors.
- Session tokens rotated regularly, stored in HTTP‑only, Secure, SameSite=Strict cookies.
- Custom log pipeline – every authentication, deletion, and admin action is timestamped with IP, user agent, and geolocation (optional).

After our public launch, we will invite **HackerOne** and **BugCrowd** white‑hats to stress‑test every corner.

---

## 👁️ Admin Dashboard – The All-Seeing Eye

Your command centre, fit for a Viking chieftain.

- Real‑time KPI cards – total users, active sessions, new posts today, message volume.
- Server health – CPU, memory, disk usage (via NameCheap metrics).
- User management – promote, suspend, or ban with one click; view reputation history.
- Content moderation – flagged posts/comments queue, with context previews.
- Audit trail – chronological feed of system events (login failures, new registrations, config changes).
- Customise themes – toggle Sci‑Fi colour palettes (Tatooine sunset, Asgard aurora, etc.)

---

## 🤖 The Great AI LLM Experiment

This repository is part of a **living article** comparing five frontier AI models:

| AI | Role |
|:--|:----|
| **CoPilot** | Assisted with API integrations and Boilerplate |
| **Gemini** | Designed the encryption architecture & logging system |
| **ChatGPT** | Crafted the frontend UX and Bootstrap layouts |
| **Claude** | Built the admin dashboard and reputation engine |
| **DeepSeek** | Optimised database queries and caching strategies |

Each model was given the same brief – we tracked speed, code quality, security awareness, and creativity. The winning AI will have its final production site pushed to **GitHub Public** with full commit history, and the article will be published on [BeardedViking.org](https://beardedviking.org) and Medium.

The winner also receives a **paid domain** and eternal bragging rights.

---

## 🚀 Deployment on NameCheap Stellar

Our hosting environment:

- **Plan** – NameCheap Shared Stellar (US Datacenter)
- **Disk** – Unmetered (currently 7 MB used)
- **Bandwidth** – Unmetered (490 MB used to date)
- **Memory** – 2 GB total (10.73 MB used – plenty of headroom)
- **CPU** – 0% idle, ready for battle

Deployment is a breeze:

1. Clone this repo into the `public_html` folder.
2. Import the provided `schema.sql` into your MySQL database.
3. Configure the `.env` file with database credentials, encryption keys, and admin email.
4. Set proper file permissions (644 for files, 755 for directories).
5. Visit your domain – the installer will run a quick health check.

*(See `INSTALL.md` for step‑by‑step, including SSL certificate setup via cPanel.)*

---

## 🤝 Contributing – Join the Warband

We welcome shield‑maidens and warriors of all skill levels!

1. Fork the repository.
2. Create a feature branch (`feat/your-idea`).
3. Commit with clear, descriptive messages.
4. Open a pull request – we review every rune.

**Areas we need help with:**
- Mobile app wrappers (PWA / React Native)
- Additional Sci‑Fi themes (Cyberpunk, Steampunk, etc.)
- Integration with Matrix/ActivityPub for federation
- Performance tuning and caching strategies

All contributors will be immortalised in our `CONTRIBUTORS.md` hall of fame.

---

## 🛡️ VDP & HackerOne – Forge the Shieldwall

Once the first stable release is live, we will launch a **Vulnerability Disclosure Program** on HackerOne and BugCrowd.

- **Scope** – All endpoints, APIs, and admin interfaces.
- **Rewards** – Swag, public recognition, and an invite to our private Slack war‑room.
- **Rules** – No testing on production user data; use our staging environment (details via email).

Our goal is to make NexusValhalla the **gold standard** for secure social platforms.

---

## 📜 License & Skål

This project is released under the **MIT License** – free to use, modify, and distribute with attribution.

---

> **“Not all who wander are lost – some are just exploring the Nexus.”**

**Maintained by** – Bearded Viking  
**Website** – [beardedviking.org](https://beardedviking.org)  
**Medium** – [@beardedviking](https://medium.com/@beardedviking)  
**Twitter/X** – @BeardedVikingIT  

*May your posts be epic, your messages encrypted, and your friends many.*

**Skål!** 🍻