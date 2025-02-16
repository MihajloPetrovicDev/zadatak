import '../app';


const saveSupplierNameButtons = document.querySelectorAll('.save-supplier-name-button');
const deleteSupplierButtons = document.querySelectorAll('.delete-supplier-button');


saveSupplierNameButtons.forEach(saveSupplierNameButton => {
    let supplierNameInput = saveSupplierNameButton.parentElement.querySelector('.supplier-name-input');
    let supplierId = saveSupplierNameButton.getAttribute('data-supplier-id');

    saveSupplierNameButton.addEventListener('click', async function(event) {
        event.preventDefault();

        try {
            const response = await axios.patch('/api/change-supplier-name', {
                newSupplierName: supplierNameInput.value,
                supplierId: supplierId
            });

            console.log(response.data.message);
        }
        catch(error) {
            console.log(error);
        }
    });
});


deleteSupplierButtons.forEach(deleteSupplierButton => {
    let supplierId = deleteSupplierButton.getAttribute('data-supplier-id');

    deleteSupplierButton.addEventListener('click', async function(event) {
        event.preventDefault();

        try {
            const response = await axios.delete('/api/delete-supplier/' + supplierId);

            deleteSupplierButton.parentElement.parentElement.remove();

            console.log(response.data.message);
        }
        catch(error) {
            console.log(error);
        }
    });
});