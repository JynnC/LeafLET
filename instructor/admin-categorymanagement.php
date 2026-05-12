<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link rel="stylesheet" href="../assets/css/admin-categorymanagement.css">
</head>
<body>
    <div class="page-shell">
        <aside class="sidebar">
            <div class="sidebar-column">
                <div class="sidebar-brand">
                    <div class="brand-icon"></div>
                    <div class="brand-copy">
                        <span class="brand-title">Category Management</span>
                    </div>
                </div>
                <div class="sidebar-icons" aria-label="Side navigation icons">
                    <button type="button" class="sidebar-icon" aria-label="Dashboard"></button>
                    <button type="button" class="sidebar-icon" aria-label="Help"></button>
                    <button type="button" class="sidebar-icon active" aria-label="Categories"></button>
                    <button type="button" class="sidebar-icon" aria-label="Courses"></button>
                </div>
            </div>
            <div class="sidebar-panel">
                <div class="sidebar-heading">CATEGORIES</div>
                <div class="category-group" role="tablist" aria-label="Category selector">
                    <button type="button" class="category-toggle active" data-category="gened">Gen. Ed</button>
                    <button type="button" class="category-toggle" data-category="profed">Prof. Ed</button>
                </div>
                <div class="major-section">
                    <button type="button" class="major-section-toggle" aria-expanded="true">
                        <span>Majors</span>
                        <span class="chevron">▾</span>
                    </button>
                    <nav class="major-list" aria-label="Major subjects"></nav>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <div class="page-heading">
                    <p class="page-eyebrow">Category Management</p>
                    <h1>General Education</h1>
                </div>
                <div class="page-actions">
                    <div class="user-chip">
                        <span class="user-role">Instructor</span>
                        <span class="user-name"></span>
                    </div>
                    <button type="button" class="create-class-button">
                        <span class="plus-sign">+</span>
                        Create Class
                    </button>
                </div>
            </header>

            <section class="cards-grid" aria-label="Class cards">
                    <article class="subject-card">
                        <div class="subject-card-header">
                            <span class="subject-card-type"></span>
                            <div class="subject-card-meta">
                                <span class="subject-card-count"></span>
                                <span class="subject-card-meta-label">Students</span>
                            </div>
                        </div>
                        <div class="subject-card-title"></div>
                        <div class="subject-card-code-row">
                            <input type="text" class="subject-code-input" readonly value="">
                            <button type="button" class="copy-button" aria-label="Copy class code"></button>
                        </div>
                        <button type="button" class="invite-button">Invite Students</button>
                    </article>
            </section>
        </main>
    </div>

    <script>
        const majorData = {
            gened: [
                "English",
                "Mathematics",
                "Social Studies",
                "Physical Ed.",
                "Science",
                "TVT Ed",
                "Elementary Ed",
                "Secondary Ed",
                "TLE Ed"
            ],
            profed: [
                "Child and Adolescent Development",
                "Principles of Teaching",
                "Curriculum Development",
                "Assessment of Learning",
                "The Teaching Profession"
            ]
        };

        const categoryButtons = document.querySelectorAll(".category-toggle");
        const majorList = document.querySelector(".major-list");
        const majorSectionToggle = document.querySelector(".major-section-toggle");
        const majorSection = document.querySelector(".major-section");
        let majorsOpen = true;

        function renderMajors(categoryKey) {
            const majors = majorData[categoryKey] || [];
            majorList.innerHTML = "";

            majors.forEach((name) => {
                const item = document.createElement("button");
                item.type = "button";
                item.className = "major-item";
                item.textContent = name;
                majorList.appendChild(item);
            });

            const isExpanded = majors.length > 0 && majorsOpen;
            majorSectionToggle.setAttribute("aria-expanded", isExpanded ? "true" : "false");
            majorList.style.display = isExpanded ? "grid" : "none";
            majorSection.classList.toggle("collapsed", !majorsOpen);
        }

        categoryButtons.forEach((button) => {
            button.addEventListener("click", () => {
                categoryButtons.forEach((btn) => btn.classList.remove("active"));
                button.classList.add("active");
                renderMajors(button.dataset.category);
            });
        });

        majorSectionToggle.addEventListener("click", () => {
            majorsOpen = !majorsOpen;
            renderMajors(document.querySelector(".category-toggle.active").dataset.category);
        });

        renderMajors("gened");
    </script>
</body>
</html>
