<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Q&A with Pagination</title>
    <link rel="stylesheet" href="css/manage.css">
    <style>
        /* Basic styling for pagination controls */
        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        .pagination button {
            margin: 0 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .pagination button.active {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .pagination button:disabled {
            background-color: #ddd;
            color: #999;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h1>Manage Chatbot Q&A</h1>

    <!-- Form to add a new entry -->
    <form id="createForm">
        <input type="text" name="question" placeholder="Question" required>
        <input type="text" name="answer" placeholder="Answer" required>
        <button type="submit">Add Entry</button>
    </form>

    <!-- Table to display entries -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="entriesTable">
            <!-- Entries will be dynamically loaded here -->
        </tbody>
    </table>

    <!-- Pagination controls -->
    <div class="pagination" id="paginationControls"></div>

    <script>
        const entriesPerPageOptions = [5, 10, 20, 50]; // Options for rows per page
        let currentPage = 1;
        let entriesPerPage = entriesPerPageOptions[0];
        let allEntries = [];

        // Fetch and render entries
        const fetchEntries = async () => {
            const response = await fetch('manage_backend.php?action=read');
            const data = await response.json();
            allEntries = data;
            renderTable();
            renderPagination();
        };

        // Render table with pagination
        const renderTable = () => {
            const table = document.getElementById('entriesTable');
            table.innerHTML = '';

            const start = (currentPage - 1) * entriesPerPage;
            const end = start + entriesPerPage;
            const paginatedEntries = allEntries.slice(start, end);

            paginatedEntries.forEach(entry => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${entry.id}</td>
                    <td><input type="text" value="${entry.question}" data-id="${entry.id}" class="edit-question"></td>
                    <td><input type="text" value="${entry.answer}" data-id="${entry.id}" class="edit-answer"></td>
                    <td>
                        <button onclick="updateEntry(${entry.id})">Update</button>
                        <button onclick="deleteEntry(${entry.id})">Delete</button>
                    </td>
                `;
                table.appendChild(row);
            });
        };

        // Render pagination controls
        const renderPagination = () => {
            const pagination = document.getElementById('paginationControls');
            pagination.innerHTML = '';

            const totalPages = Math.ceil(allEntries.length / entriesPerPage);

            // Add "Previous" button
            const prevButton = document.createElement('button');
            prevButton.textContent = 'Previous';
            prevButton.disabled = currentPage === 1;
            prevButton.onclick = () => {
                currentPage--;
                renderTable();
                renderPagination();
            };
            pagination.appendChild(prevButton);

            // Add page buttons
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.className = i === currentPage ? 'active' : '';
                pageButton.onclick = () => {
                    currentPage = i;
                    renderTable();
                    renderPagination();
                };
                pagination.appendChild(pageButton);
            }

            // Add "Next" button
            const nextButton = document.createElement('button');
            nextButton.textContent = 'Next';
            nextButton.disabled = currentPage === totalPages;
            nextButton.onclick = () => {
                currentPage++;
                renderTable();
                renderPagination();
            };
            pagination.appendChild(nextButton);
        };

        // Update entry
        const updateEntry = async (id) => {
            const question = document.querySelector(`.edit-question[data-id="${id}"]`).value;
            const answer = document.querySelector(`.edit-answer[data-id="${id}"]`).value;

            const formData = new FormData();
            formData.append('action', 'update');
            formData.append('id', id);
            formData.append('question', question);
            formData.append('answer', answer);

            await fetch('manage_backend.php', { method: 'POST', body: formData });
            fetchEntries();
        };

        // Delete entry
        const deleteEntry = async (id) => {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            await fetch('manage_backend.php', { method: 'POST', body: formData });
            fetchEntries();
        };

        // Handle form submission for adding new entries
        document.getElementById('createForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(event.target);
            formData.append('action', 'create');

            await fetch('manage_backend.php', { method: 'POST', body: formData });
            fetchEntries();
        });

        // Initial fetch
        fetchEntries();
    </script>
</body>
</html>
