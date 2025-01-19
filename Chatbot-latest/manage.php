    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Chatbot Q&A</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="css/manage.css">
    </head>
    <body>
        <h1>Manage Chatbot Q&A</h1>

        <!-- Button to open modal for adding entries -->
        <div class="buttons">
        <button class="open-modal-btn" onclick="openCreateModal()">Add New Entry</button>
        <button class="back-btn" onclick="window.location.href='chatbot.php'">Back to Chatbot</button>
    </div>

        <!-- Modal for Adding -->
        <div class="modal" id="createModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add Entry</h2>
                    <button class="close-modal" onclick="closeCreateModal()">&times;</button>
                </div>
                <form id="createForm">
                    <input type="text" name="question" placeholder="Enter Question" required>
                    <input type="text" name="answer" placeholder="Enter Answer" required>
                    <div class="modal-footer">
                        <button type="button" onclick="closeCreateModal()">Cancel</button>
                        <button type="submit">Add Entry</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal for Updating -->
        <div class="modal" id="updateModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Update Entry</h2>
                    <button class="close-modal" onclick="closeUpdateModal()">&times;</button>
                </div>
                <form id="updateForm">
                    <input type="hidden" name="id" id="updateId">
                    <input type="text" name="question" id="updateQuestion" placeholder="Enter Question" required>
                    <input type="text" name="answer" id="updateAnswer" placeholder="Enter Answer" required>
                    <div class="modal-footer">
                        <button type="button" onclick="closeUpdateModal()">Cancel</button>
                        <button type="submit">Update Entry</button>
                    </div>
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="entriesTable">
                <!-- Dynamic Entries -->
            </tbody>
        </table>

        <div class="pagination" id="paginationControls"></div>

        <script>
            const entriesPerPageOptions = [5, 10, 20, 50];
            let currentPage = 1;
            let entriesPerPage = entriesPerPageOptions[0];
            let allEntries = [];

            const openCreateModal = () => {
                document.getElementById('createModal').style.display = 'flex';
            };

            const closeCreateModal = () => {
                document.getElementById('createModal').style.display = 'none';
            };

            const openUpdateModal = (id, question, answer) => {
                document.getElementById('updateId').value = id;
                document.getElementById('updateQuestion').value = question;
                document.getElementById('updateAnswer').value = answer;
                document.getElementById('updateModal').style.display = 'flex';
            };

            const closeUpdateModal = () => {
                document.getElementById('updateModal').style.display = 'none';
            };

            const fetchEntries = async () => {
                try {
                    const response = await fetch('manage_backend.php?action=read');
                    const data = await response.json();
                    allEntries = data;
                    renderTable();
                    renderPagination();
                } catch (error) {
                    console.error('Error fetching entries:', error);
                }
            };

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
                        <td>${entry.question}</td>
                        <td>${entry.answer}</td>
                        <td>
                            <button class="updte" onclick="openUpdateModal(${entry.id}, '${entry.question}', '${entry.answer}')">Update</button>
                            <button class="delte" onclick="deleteEntry(${entry.id})">Delete</button>
                        </td>
                    `;
                    table.appendChild(row);
                });
            };

            const renderPagination = () => {
                const pagination = document.getElementById('paginationControls');
                pagination.innerHTML = '';

                const totalPages = Math.ceil(allEntries.length / entriesPerPage);

                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.disabled = currentPage === 1;
                prevButton.onclick = () => {
                    currentPage--;
                    renderTable();
                    renderPagination();
                };
                pagination.appendChild(prevButton);

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

            const deleteEntry = async (id) => {
    if (confirm('Are you sure you want to delete this entry?')) {
        try {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            await fetch('manage_backend.php', {
                method: 'POST',
                body: formData
            });

            fetchEntries();
        } catch (error) {
            console.error('Error deleting entry:', error);
        }
    }
};

            document.getElementById('createForm').addEventListener('submit', async (event) => {
                event.preventDefault();
                const formData = new FormData(event.target);
                formData.append('action', 'create');

                try {
                    await fetch('manage_backend.php', { method: 'POST', body: formData });
                    closeCreateModal();
                    fetchEntries();
                } catch (error) {
                    console.error('Error creating entry:', error);
                }
            });

            document.getElementById('updateForm').addEventListener('submit', async (event) => {
                event.preventDefault();
                const formData = new FormData(event.target);
                formData.append('action', 'update');

                try {
                    await fetch('manage_backend.php', { method: 'POST', body: formData });
                    closeUpdateModal();
                    fetchEntries();
                } catch (error) {
                    console.error('Error updating entry:', error);
                }
            });

            fetchEntries();
        </script>
    </body>
    </html>
