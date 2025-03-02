function validateTitlePageFileType() {
    var allowedExtensions = ['docx', 'tex']; // Разрешените разширения за файлове

    var files = document.getElementById('upload1').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {
        var fileExtension = files[i].name.split('.').pop().toLowerCase(); // Вземаме разширението на файла и го конвертираме към малки букви

        if (allowedExtensions.indexOf(fileExtension) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('title_page_error').innerText = '';
        return true;
    } else {
        // Показване на съобщение за грешка
        document.getElementById('title_page_error').innerText =
            'Invalid file type. Please select docx or LaTex doc files.';
        // Изчистване на стойността на input полето
        document.getElementById('upload1').value = '';
    }
}



function validateManuscriptFileType() {
    var allowedExtensions = ['docx', 'tex']; // Разрешените разширения за файлове

    var files = document.getElementById('upload2').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {
        var fileExtension = files[i].name.split('.').pop().toLowerCase(); // Вземаме разширението на файла и го конвертираме към малки букви

        if (allowedExtensions.indexOf(fileExtension) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('manuscript_error').innerText = '';
    } else {
        // Показване на съобщение за грешка
        document.getElementById('manuscript_error').innerText =
            'Invalid file type. Please select docx or LaTex doc files.';
        // Изчистване на стойността на input полето
        document.getElementById('upload2').value = '';
    }
}


function validateFiguresFileType() {

    var allowedTypes = ['image/jpeg',];

    var files = document.getElementById('upload3').files;

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
        'Invalid file type. Please select jpg files.';
        // Изчистете стойността на input полето
        document.getElementById('upload3').value = '';
    }
}


function validateTablesFileType() {
    var allowedExtensions = ['docx']; // Разрешените разширения за файлове

    var files = document.getElementById('upload4').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {
        var fileExtension = files[i].name.split('.').pop().toLowerCase(); // Вземаме разширението на файла и го конвертираме към малки букви

        if (allowedExtensions.indexOf(fileExtension) === -1) {
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
            'Invalid file type. Please select docx files.';
        // Изчистване на стойността на input полето
        document.getElementById('upload4').value = '';
    }
}


function validateSupplementaryFileType() {
    var allowedTypes = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf', 'image/png', 'image/jpeg'];

    var files = document.getElementById('upload5').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {
        var fileExtension = files[i].name.split('.').pop().toLowerCase(); // Вземаме разширението на файла и го конвертираме към малки букви

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
            'Invalid file type. Please select docx, xls, xlsx, pdf, png, or jpg files.';
        // Изчистване на стойността на input полето
        document.getElementById('upload5').value = '';
    }
}



function validateCoverLaterFileType() {
    var allowedExtensions = ['docx', 'tex']; // Разрешените разширения за файлове
    var files = document.getElementById('upload6').files;

    var isValid = true;

    for (var i = 0; i < files.length; i++) {
        var fileExtension = files[i].name.split('.').pop().toLowerCase(); // Вземаме разширението на файла и го конвертираме към малки букви

        if (allowedExtensions.indexOf(fileExtension) === -1) {
            isValid = false;
            break;
        }
    }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('cover_letter_error').innerText = '';
    } else {
        // Показване на съобщение за грешка
        document.getElementById('cover_letter_error').innerText =
            'Invalid file type. Please select docx files.';
        // Изчистване на стойността на input полето
        document.getElementById('upload6').value = '';
    }
}



function validateZIPFileType() {

    var allowedTypes = ['application/zip', 'application/x-zip-compressed', 'application/x-compressed', 'multipart/x-zip'];

    var file = document.getElementById('zip_file').files[0]; // Вземете първия (единствен) файл от input

    var isValid = false; // Предполагаме, че файла не е валиден по подразбиране

    if (file && allowedTypes.indexOf(file.type) !== -1) {
        // Проверка дали файлът съществува и дали неговият тип е в списъка с разрешени типове
        isValid = true;
    }

    // for (var i = 0; i < files.length; i++) {
    //     if (allowedTypes.indexOf(files[i].type) === -1) {
    //         isValid = false;
    //         break;
    //     }
    // }

    if (isValid) {
        // Файловете са валидни, няма грешка
        document.getElementById('zip_file_error').innerText = '';
    } else {
        // Покажете съобщение за грешка
        document.getElementById('zip_file_error').innerText =
        'Invalid file type. Please select ZIP file.';
        // Изчистете стойността на input полето
        document.getElementById('zip_file').value = '';
    }
}



















