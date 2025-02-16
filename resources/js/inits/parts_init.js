import '../app';


const savePartButtons = document.querySelectorAll('.save-part-button');
const deletePartButtons = document.querySelectorAll('.delete-part-button');
const downloadSupplierPartsCsvButton = document.getElementById('download-supplier-parts-csv-button');


savePartButtons.forEach(savePartButton => {
    const partContainer = savePartButton.parentElement;

    let partId = savePartButton.getAttribute('data-part-id');
    let supplierSelect = partContainer.querySelector('.supplier-select');
    let daysValidInput = partContainer.querySelector('.days-valid-input');
    let priorityInput = partContainer.querySelector('.priority-input');
    let partsNumberInput = partContainer.querySelector('.part-number-input');
    let partsDescriptionInput = partContainer.querySelector('.part-description-input');
    let quantityInput = partContainer.querySelector('.quantity-input');
    let priceInput = partContainer.querySelector('.price-input');
    let conditionSelect = partContainer.querySelector('.condition-select');
    let categorySelect = partContainer.querySelector('.category-select');


    savePartButton.addEventListener('click', async function(event) {
        event.preventDefault();

        try {
            const response = await axios.patch('/api/update-part', {
                partId: partId,
                supplierId: supplierSelect.value,
                daysValid: daysValidInput.value,
                priority: priorityInput.value,
                partNumber: partsNumberInput.value,
                partDescription: partsDescriptionInput.value,
                quantity: quantityInput.value,
                price: priceInput.value,
                conditionId: conditionSelect.value,
                categoryId: categorySelect.value
            });

            console.log(response.data.message);
        }
        catch(error) {
            console.log(error);
        }
    });
});


deletePartButtons.forEach(deletePartButton => {
    let partId = deletePartButton.getAttribute('data-part-id');

    deletePartButton.addEventListener('click', async function(event) {
        event.preventDefault();

        try {
            const response = await axios.delete('/api/delete-part/' + partId);

            deletePartButton.parentElement.remove();
            console.log(response.data.message);
        }
        catch(error) {
            console.log(error);
        }
    });
});


downloadSupplierPartsCsvButton.addEventListener('click', function(event) {
        event.preventDefault();

        let supplierId = downloadSupplierPartsCsvButton.getAttribute('data-supplier-id');

        window.location.href = '/download-supplier-parts-csv/' + supplierId;
});