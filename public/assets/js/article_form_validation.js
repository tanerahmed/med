function validateTitlePageFileType() {

    var allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/x-latex'];

    var files = document.getElementById('title_pages').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {

        if (allowedTypes.indexOf(files[i].type) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('title_page_error').innerText = '';
    } else {
        // Покажете съобщение за грешка
        document.getElementById('title_page_error').innerText =
        'Invalid file type. Please select doc, docx or LaTex doc files.';
        // Изчистете стойността на input полето
        document.getElementById('title_pages').value = '';
    }
}


function validateManuscriptFileType() {

    var allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/x-latex'];

    var files = document.getElementById('manuscript').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {

        if (allowedTypes.indexOf(files[i].type) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('manuscript_error').innerText = '';
    } else {
        // Покажете съобщение за грешка
        document.getElementById('manuscript_error').innerText =
        'Invalid file type. Please select doc, docx or LaTex doc files.';
        // Изчистете стойността на input полето
        document.getElementById('manuscript').value = '';
    }
}

function validateFiguresFileType() {

    var allowedTypes = ['image/jpeg', 'image/tiff'];

    var files = document.getElementById('figures').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {

        if (allowedTypes.indexOf(files[i].type) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('figures_error').innerText = '';
    } else {
        // Покажете съобщение за грешка
        document.getElementById('figures_error').innerText =
        'Invalid file type. Please select jpg or TIFF files.';
        // Изчистете стойността на input полето
        document.getElementById('figures').value = '';
    }
}


function validateTablesFileType() {

    var allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'];

    var files = document.getElementById('tables').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {

        if (allowedTypes.indexOf(files[i].type) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('tables_error').innerText = '';
    } else {
        // Покажете съобщение за грешка
        document.getElementById('tables_error').innerText =
        'Invalid file type. Please select doc or docx files.';
        // Изчистете стойността на input полето
        document.getElementById('tables').value = '';
    }
}

function validateSupplementaryFileType() {

    var allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf', 'image/jpeg', 'image/tiff'];

    var files = document.getElementById('supplementary').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {

        if (allowedTypes.indexOf(files[i].type) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('supplementary_error').innerText = '';
    } else {
        // Покажете съобщение за грешка
        document.getElementById('supplementary_error').innerText =
        'Invalid file type. Please select doc, docx, xls, xlsx, pdf, jpg or tiff files.';
        // Изчистете стойността на input полето
        document.getElementById('supplementary').value = '';
    }
}


function validateCoverLaterFileType() {

    var allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/x-latex'];

    var files = document.getElementById('cover_letter').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {

        if (allowedTypes.indexOf(files[i].type) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('cover_letter_error').innerText = '';
    } else {
        // Покажете съобщение за грешка
        document.getElementById('cover_letter_error').innerText =
        'Invalid file type. Please select doc or docx files.';
        // Изчистете стойността на input полето
        document.getElementById('cover_letter').value = '';
    }
}


















