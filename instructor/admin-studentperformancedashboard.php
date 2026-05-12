<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Performances</title>
    <link rel="stylesheet" href="../assets/css/admin-studentperformancedashboard.css">
</head>
<body>
    <header class="topbar">
        <div class="topbar-brand">
            <div class="brand-icon"></div>
            <div>
                <div class="topbar-title">Student Performances</div>
            </div>
        </div>
        <div class="topbar-profile">
            <div class="profile-copy">
                <span class="profile-name"></span>
                <span class="profile-role">Instructor</span>
            </div>
            <div class="profile-avatar"></div>
        </div>
    </header>

    <div class="page-shell dashboard-shell">
        <aside class="sidebar">
            <div class="sidebar-column">
                <div class="sidebar-brand">
                    <div class="brand-icon"></div>
                </div>
                <div class="sidebar-icons" aria-label="Side navigation icons">
                    <button type="button" class="sidebar-icon" aria-label="Dashboard"></button>
                    <button type="button" class="sidebar-icon" aria-label="Help"></button>
                    <button type="button" class="sidebar-icon active" aria-label="Categories"></button>
                    <button type="button" class="sidebar-icon" aria-label="Courses"></button>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <section class="dashboard-top">
                <div class="stats-grid">
                    <article class="stat-card">
                        <div class="stat-icon"></div>
                        <div class="stat-label">Total Students</div>
                        <div class="stat-value"></div>
                    </article>
                    <article class="stat-card">
                        <div class="stat-icon"></div>
                        <div class="stat-label">Total Lessons</div>
                        <div class="stat-value"></div>
                    </article>
                    <article class="stat-card">
                        <div class="stat-icon"></div>
                        <div class="stat-label">Total Quizzes</div>
                        <div class="stat-value"></div>
                    </article>
                </div>
                <div class="chart-card">
                    <div class="chart-ring"></div>
                    <div class="chart-legend">
                        <span class="legend-item"><span class="legend-dot male"></span>Male</span>
                        <span class="legend-item"><span class="legend-dot female"></span>Female</span>
                    </div>
                </div>
            </section>

            <section class="dashboard-body">
                <div class="tab-row" role="tablist" aria-label="Dashboard tabs">
                    <button type="button" class="tab-button active" data-tab="users">Users</button>
                    <button type="button" class="tab-button" data-tab="lessons">Lessons</button>
                </div>

                <div class="control-row">
                    <span class="filter-icon" aria-hidden="true"></span>
                    <div class="controls users-controls">
                        <label class="select-wrapper">
                            <select id="student-ranking" aria-label="Ranking filter">
                                <option value="ranking">Ranking</option>
                                <option value="streak">Streak</option>
                                <option value="achievements">Achievements</option>
                            </select>
                        </label>
                        <label class="select-wrapper">
                            <select id="student-order" aria-label="Order filter">
                                <option value="ascending">Ascending</option>
                                <option value="descending">Descending</option>
                            </select>
                        </label>
                        <button type="button" id="view-all-students" class="action-button">View All Students</button>
                    </div>
                    <div class="controls lessons-controls hidden">
                        <label class="select-wrapper">
                            <select id="lesson-category" aria-label="Lesson category filter">
                                <option value="all">All Categories</option>
                                <option value="gened">Gen. Ed</option>
                                <option value="profed">Prof. Ed</option>
                            </select>
                        </label>
                        <button type="button" id="add-lesson-button" class="action-button add-button">Add Lesson</button>
                    </div>
                </div>

                <div class="table-panel">
                    <div class="users-table" id="users-table-panel">
                        <table class="data-table" aria-label="Students table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Streak</th>
                                    <th>Achievements</th>
                                    <th>Ranking</th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body"></tbody>
                        </table>
                    </div>

                    <div class="lessons-list hidden" id="lessons-panel">
                        <div id="lesson-items" class="lesson-items"></div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        const students = [];
        const lessons = [];

        const tabs = document.querySelectorAll('.tab-button');
        const usersControls = document.querySelector('.users-controls');
        const lessonsControls = document.querySelector('.lessons-controls');
        const usersPanel = document.getElementById('users-table-panel');
        const lessonsPanel = document.getElementById('lessons-panel');
        const usersTableBody = document.getElementById('users-table-body');
        const lessonItems = document.getElementById('lesson-items');
        const studentRanking = document.getElementById('student-ranking');
        const studentOrder = document.getElementById('student-order');
        const lessonCategory = document.getElementById('lesson-category');
        const viewAllStudents = document.getElementById('view-all-students');
        const addLessonButton = document.getElementById('add-lesson-button');

        function renderUsers() {
            usersTableBody.innerHTML = '';

            if (students.length === 0) {
                const emptyRow = document.createElement('tr');
                emptyRow.className = 'empty-row';
                emptyRow.innerHTML = '<td colspan="6">No student records available.</td>';
                usersTableBody.appendChild(emptyRow);
                return;
            }

            const sortedStudents = [...students].sort((a, b) => {
                const field = studentRanking.value;
                if (a[field] === b[field]) return 0;
                if (studentOrder.value === 'ascending') {
                    return a[field] > b[field] ? 1 : -1;
                }
                return a[field] < b[field] ? 1 : -1;
            });

            sortedStudents.forEach((student) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${student.id || ''}</td>
                    <td>${student.name || ''}</td>
                    <td>${student.gender || ''}</td>
                    <td>${student.streak || ''}</td>
                    <td>${student.achievements || ''}</td>
                    <td>${student.ranking || ''}</td>
                `;
                usersTableBody.appendChild(row);
            });
        }

        function renderLessons() {
            lessonItems.innerHTML = '';
            const category = lessonCategory.value;
            const filteredLessons = lessons.filter((lesson) => category === 'all' || lesson.category === category);

            if (filteredLessons.length === 0) {
                const emptyBox = document.createElement('div');
                emptyBox.className = 'empty-lessons';
                emptyBox.textContent = 'No lessons available.';
                lessonItems.appendChild(emptyBox);
                return;
            }

            filteredLessons.forEach((lesson) => {
                const item = document.createElement('div');
                item.className = 'lesson-item';
                item.innerHTML = `
                    <div class="lesson-title">
                        <span class="lesson-category">${lesson.categoryLabel || ''}</span>
                        <span class="lesson-name">${lesson.title || ''}</span>
                    </div>
                    <div class="lesson-actions">
                        <button type="button" class="lesson-action-btn edit-btn" aria-label="Edit lesson"></button>
                        <button type="button" class="lesson-action-btn delete-btn" aria-label="Delete lesson"></button>
                    </div>
                `;
                lessonItems.appendChild(item);
            });
        }

        function setActiveTab(tabName) {
            tabs.forEach((tab) => {
                tab.classList.toggle('active', tab.dataset.tab === tabName);
            });

            usersControls.classList.toggle('hidden', tabName !== 'users');
            lessonsControls.classList.toggle('hidden', tabName !== 'lessons');
            usersPanel.classList.toggle('hidden', tabName !== 'users');
            lessonsPanel.classList.toggle('hidden', tabName !== 'lessons');
        }

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                setActiveTab(tab.dataset.tab);
            });
        });

        studentRanking.addEventListener('change', renderUsers);
        studentOrder.addEventListener('change', renderUsers);
        lessonCategory.addEventListener('change', renderLessons);

        viewAllStudents.addEventListener('click', () => {
            studentRanking.value = 'ranking';
            studentOrder.value = 'ascending';
            renderUsers();
        });

        addLessonButton.addEventListener('click', (event) => {
            event.preventDefault();
        });

        renderUsers();
        renderLessons();
    </script>
</body>
</html>
