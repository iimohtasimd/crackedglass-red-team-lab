# 🔐 Operation Cracked Glass — Red Team Security Assessment

A controlled cybersecurity laboratory assessment focused on **reconnaissance, password recovery, intelligence correlation, PDF security analysis, and local web authentication testing**.

> **⚠️ Authorized Laboratory Use Only**
> All security testing described in this repository was performed within the authorized VaultofCodes **Cracked Glass** laboratory environment. Web authentication testing was strictly restricted to the local system (`127.0.0.1`).

---

## 📌 Project Overview

**Operation "Cracked Glass"** demonstrates how information gathered during reconnaissance can be correlated with predictable password patterns and weak authentication controls during an authorized security assessment.

The assessment followed this workflow:

```text
Reconnaissance
     ↓
Recon.pdf Analysis
     ↓
Password Recovery
     ↓
Employee Information Extraction
     ↓
Targeted Wordlist Generation
     ↓
DataBreach.pdf Analysis
     ↓
Password Pattern Analysis
     ↓
Local PHP Application Setup
     ↓
Authentication Testing
     ↓
Security Findings & Recommendations
```

The assessment successfully:

* Recovered the password of `Recon.pdf`
* Extracted reconnaissance information
* Generated a reconnaissance-driven password candidate list
* Recovered the password of `DataBreach.pdf`
* Analyzed PDF encryption metadata
* Deployed the supplied PHP login application using Apache
* Validated local authentication
* Performed a controlled Hydra test against `127.0.0.1`

These activities and results are documented in the accompanying assessment report.

---

## 🎯 Objectives

The main objectives of the assessment were:

* Analyze reconnaissance information
* Recover the protected `Recon.pdf`
* Extract and analyze employee information
* Generate targeted password candidates
* Analyze `DataBreach.pdf`
* Recover the protected DataBreach contents
* Analyze PDF metadata and encryption
* Deploy the vulnerable PHP login application
* Configure Apache on Kali Linux
* Perform controlled authentication testing against localhost
* Document findings, evidence, limitations, and recommendations

---

## 🖥️ Lab Environment

| Component              | Details                            |
| ---------------------- | ---------------------------------- |
| Operating System       | Kali Linux                         |
| Web Server             | Apache2                            |
| Web Application        | PHP `login.php`                    |
| Web Target             | Localhost                          |
| Authentication Target  | `127.0.0.1`                        |
| PDF Analysis           | `pdfinfo`, `pdftotext`, `ExifTool` |
| Password Analysis      | `pdf2john.pl`, John the Ripper     |
| Authentication Testing | Hydra                              |
| Browser                | Firefox                            |
| Shell Tools            | Linux shell, `grep`                |

The project report identifies the local web target as `http://localhost/login.php`.

---

## 📂 Project Structure

```text
CrackedGlass/
│
├── files/
│   ├── Recon.pdf
│   ├── DataBreach.pdf
│   ├── Readme.txt
│   ├── Readme2.txt
│   ├── recon_hash.txt
│   ├── databreach_hash.txt
│   ├── recon.txt
│   ├── recon_wordlist.txt
│   ├── databreach_candidates.txt
│   ├── wordlist.txt
│   └── login.php
│
├── evidence/
│   └── screenshots/
│
└── README.md
```

The report identifies the project directory as:

```text
/home/kali/Desktop/Cybersecurity/VaultofCodes/CrackedGlass
```

and documents the relevant assessment files and evidence directory.

---

## 🔎 Assessment Stages

### 1. Recon.pdf Analysis

`Recon.pdf` was identified as a password-protected document.

The PDF password hash was extracted using:

```bash
/usr/share/john/pdf2john.pl Recon.pdf > recon_hash.txt
```

An offline dictionary-based recovery attempt was performed using John the Ripper:

```bash
john --format=PDF --wordlist=/usr/share/wordlists/rockyou.txt recon_hash.txt
```

The recovered password was verified with:

```bash
john --show --format=PDF recon_hash.txt
```

The password was successfully recovered during the assessment.

The document was then extracted using:

```bash
pdftotext -layout -upw 'admin1234' Recon.pdf recon.txt
```

The extracted reconnaissance information included employee-related details such as names, employee IDs, dates of birth, mobile numbers, email addresses, cities, interests, and notes.

---

### 2. Targeted Wordlist Generation

Information obtained from the reconnaissance stage was used to create targeted password candidates.

The wordlist strategy considered:

* Employee names
* Name fragments
* Initials
* Dates and years
* Pet names
* Interests and hobbies
* Sports-related information
* Name + year combinations
* Word + special character + number patterns

The objective was to demonstrate how exposed personal information can reduce the password-search space during an authorized assessment.

---

### 3. DataBreach.pdf Analysis

The second protected document was analyzed after reconnaissance.

Hash extraction:

```bash
/usr/share/john/pdf2john.pl DataBreach.pdf > databreach_hash.txt
```

Initial recovery attempts were performed using targeted candidates and broader dictionaries.

When those attempts were unsuccessful, additional password-pattern candidates were generated.

The successful recovery used a pattern consisting of:

```text
word + special character + four-digit year
```

The recovered password allowed further analysis of the document.

PDF metadata was examined using:

```bash
exiftool DataBreach.pdf
```

The report identified:

* PDF Version: `1.4`
* Encryption Standard: `V2.3`
* Encryption Strength: `128-bit`
* Document Status: Password protected

---

### 4. Local Web Application Setup

The supplied PHP application was deployed to Apache's web root.

Apache was started using:

```bash
sudo systemctl start apache2
```

Service status was checked with:

```bash
sudo systemctl status apache2
```

PHP syntax was validated using:

```bash
php -l /var/www/html/login.php
```

After correcting a syntax issue, the application was successfully served locally.

The application was accessed through:

```text
http://localhost/login.php
```

---

### 5. Controlled Authentication Testing

The local application was first tested manually.

The laboratory credential was accepted by the application, confirming successful authentication.

A controlled Hydra test was then performed **only against the local loopback address**:

```bash
hydra -l admin -P hydra_wordlist.txt 127.0.0.1 http-post-form \
"/login.php:username=^USER^&password=^PASS^:Invalid credentials."
```

The candidate list contained only four entries:

```text
wrongpassword
admin123
password123
admin1234
```

The test identified the valid laboratory credential:

```text
Username: admin
Password: password123
```

Hydra reported one valid password and successfully completed the localhost target.

---

## 📊 Results

| Assessment Activity             | Result    |
| ------------------------------- | --------- |
| Recon.pdf password recovery     | Completed |
| Reconnaissance data extraction  | Completed |
| Targeted wordlist creation      | Completed |
| DataBreach hash extraction      | Completed |
| DataBreach password recovery    | Completed |
| PDF metadata analysis           | Completed |
| PHP deployment                  | Completed |
| Apache configuration            | Completed |
| Manual localhost authentication | Completed |
| Hydra localhost test            | Completed |

The assessment report records successful completion of all major project components.

---

## 🔐 Security Findings

### Weak Passwords

The assessment demonstrated that predictable passwords can be susceptible to dictionary and targeted password-recovery techniques.

### Personal Information Exposure

Names, dates, interests, pet names, and other personal information can potentially provide useful material for password candidate generation.

### Predictable Password Patterns

Patterns such as:

```text
word + special character + year
```

can make password recovery easier when attackers have contextual information.

### Weak Authentication Controls

The local PHP application accepted a simple credential and did not demonstrate effective rate limiting during the controlled test.

---

## 🛡️ Recommendations

The assessment recommends:

1. Use long, strong, and unique passwords.
2. Avoid using publicly discoverable personal information in passwords.
3. Enable Multi-Factor Authentication (MFA).
4. Implement authentication rate limiting.
5. Use account protection mechanisms such as progressive delays or carefully designed lockouts.
6. Minimize unnecessary exposure of employee personal information.
7. Never store passwords in plaintext.
8. Use modern password hashing algorithms such as Argon2id, bcrypt, or scrypt.
9. Monitor repeated authentication failures.
10. Protect sensitive documents with strong unique credentials.
11. Separate laboratory, development, testing, and production credentials.
12. Rotate credentials that become exposed during testing.

---

## 📸 Evidence

The assessment includes supporting screenshots documenting:

* Project directory
* Recon.pdf hash extraction
* Recon.pdf password recovery
* Reconnaissance data extraction
* Apache service status
* Successful local authentication
* Hydra localhost testing
* DataBreach password-hint information
* DataBreach metadata and encryption analysis

Evidence is stored in the `evidence/` directory.

---

## 🧰 Command Reference

### Recon.pdf

```bash
pdfinfo Recon.pdf

/usr/share/john/pdf2john.pl Recon.pdf > recon_hash.txt

john --format=PDF --wordlist=/usr/share/wordlists/rockyou.txt recon_hash.txt

john --show --format=PDF recon_hash.txt

pdftotext -layout -upw 'admin1234' Recon.pdf recon.txt
```

### DataBreach.pdf

```bash
pdfinfo DataBreach.pdf

/usr/share/john/pdf2john.pl DataBreach.pdf > databreach_hash.txt

john --format=PDF --wordlist=databreach_candidates.txt databreach_hash.txt

john --show --format=PDF databreach_hash.txt

pdftotext -layout -upw 'admin@1980' DataBreach.pdf databreach.txt

exiftool DataBreach.pdf
```

### Apache / PHP

```bash
sudo systemctl start apache2

sudo systemctl status apache2

php -l /var/www/html/login.php
```

### Hydra — Localhost Only

```bash
hydra -l admin -P hydra_wordlist.txt 127.0.0.1 http-post-form \
"/login.php:username=^USER^&password=^PASS^:Invalid credentials."
```

### Stop Apache

```bash
sudo systemctl stop apache2
```

These commands correspond to the command references documented in the assessment report.

---

## ⚖️ Ethical & Scope Statement

This project was conducted as an **authorized cybersecurity laboratory exercise**.

All authentication testing was restricted to the student's own locally hosted application at:

```text
127.0.0.1
```

No external, third-party, or production systems were targeted.

The techniques and findings documented in this repository are intended exclusively for:

* Authorized security testing
* Cybersecurity education
* Laboratory environments
* Defensive security research

Do not apply these techniques to systems, accounts, applications, files, or networks without explicit authorization.

---

## 👤 Author

**Md Mohtasim**

**Role:** Junior Security Analyst (Trainee)

**Project:** Operation "Cracked Glass"

**Platform:** Kali Linux

**Lab:** VaultofCodes – Cracked Glass

**Date:** August 2026

---

## 📄 Project Report

The complete assessment report contains the methodology, evidence, results, security observations, recommendations, command reference, and appendices supporting this project.

---

⭐ **If you find this project useful, consider starring the repository.**
