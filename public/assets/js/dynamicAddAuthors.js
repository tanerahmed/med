//  // JavaScript код за добавяне на автори

document.addEventListener('DOMContentLoaded', function() {
    var authorsContainer = document.getElementById('authorsContainer');
    var addAuthorButton = document.getElementById('addAuthorButton');
    var authorIndex = 1; // Индекс за идентификация на полетата на авторите

    addAuthorButton.addEventListener('click', function() {
        // <h3>Co Author ${authorIndex}</h3>
        var authorFields = `            
            <div class="author-row">
            <h3>Co Author</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label for="author_${authorIndex}" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="authors[${authorIndex}][first_name]" placeholder="First Name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="middle_name_${authorIndex}" class="form-label">Middle Name/Initial:</label>
                        <input type="text" class="form-control" name="authors[${authorIndex}][middle_name]" placeholder="Middle Name/Initial">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="family_name_${authorIndex}" class="form-label">Family Name:</label>
                        <input type="text" class="form-control" name="authors[${authorIndex}][family_name]" placeholder="Family Name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="primary_affiliation_${authorIndex}" class="form-label">Primary Affiliation:</label>
                        <input type="text" class="form-control" name="authors[${authorIndex}][primary_affiliation]" placeholder="Primary Affiliation" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="contact_${authorIndex}" class="form-label">Contact (E-mail):</label>
                        <input type="email" class="form-control" name="authors[${authorIndex}][contact]" placeholder="E-mail" required>

                    <div>
                        <label for="position">Position</label>
                        <input type="number" name="authors[${authorIndex}][position]" class="form-control">
                    </div>

                    <div>
                        <label for="is_corresponding_author">
                            <input type="checkbox" name="authors[${authorIndex}][is_corresponding_author]" value="1">
                            Corresponding Author
                        </label>
                    </div>

                    </div>
                    <div class="col-md-6">
                        <label for="author_contributions_${authorIndex}" class="form-label">Author Contributions Statement:</label>
                        <textarea class="form-control" name="authors[${authorIndex}][contributions]" placeholder="Author Contributions Statement" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger" onclick="removeAuthor(this)">Remove Author</button>
                    </div>
                </div>
            </div>
        `;
        authorsContainer.insertAdjacentHTML('beforeend', authorFields);
        authorIndex++; // Увеличаваме индекса за следващия автор
    });
});

function removeAuthor(button) {
    var authorRow = button.closest('.author-row');
    authorRow.remove();
}
