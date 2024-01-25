// document.addEventListener('DOMContentLoaded', function () {
//     var specialtySelect = document.getElementById('specialty');
//     var scientificAreaSelect = document.getElementById('scientific_area');

//     var scientificAreas = {
//         'Урология': ['мъжка урология', 'дамска урология'],
//         'УНГ': ['вътрешно ухо', 'външно ухо', 'унг3'],
//         // Добавете други специалности и научни области
//     };

//     specialtySelect.addEventListener('change', function () {
//         var selectedSpecialty = specialtySelect.value;

//         if (scientificAreas.hasOwnProperty(selectedSpecialty)) {
//             var scientificAreasOptions = scientificAreas[selectedSpecialty];
//             updateScientificAreaOptions(scientificAreasOptions);
//         } else {
//             updateScientificAreaOptions([]);
//         }
//     });

//     function updateScientificAreaOptions(options) {
//         // Изчистете текущите опции
//         scientificAreaSelect.innerHTML = '';

//         // Добавете новите опции
//         options.forEach(function (value) {
//             var option = document.createElement('option');
//             option.text = value;
//             option.value = value;
//             scientificAreaSelect.add(option);
//         });
//     }
// });

document.addEventListener('DOMContentLoaded', function () {
    var specialtySelect = document.getElementById('specialty');
    var scientificAreaSelect = document.getElementById('scientific_area');

    var scientificAreas = {
        'Урология': ['мъжка урология', 'дамска урология'],
        'УНГ': ['вътрешно ухо', 'външно ухо', 'унг3'],
        // Добавете други специалности и научни области
    };

    specialtySelect.addEventListener('change', function () {
        var selectedSpecialty = specialtySelect.value;

        if (scientificAreas.hasOwnProperty(selectedSpecialty)) {
            var scientificAreasOptions = scientificAreas[selectedSpecialty];
            updateScientificAreaOptions(scientificAreasOptions);
        } else {
            updateScientificAreaOptions([]);
        }
    });

    function updateScientificAreaOptions(options) {
        // Изчистете текущите опции
        scientificAreaSelect.innerHTML = '';

        // Добавете новите опции
        options.forEach(function (value) {
            var option = document.createElement('option');
            
            option.text = value;
            option.value = value;
            scientificAreaSelect.add(option);
        });
    }
});
