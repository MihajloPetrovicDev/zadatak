import '../app';

const saveSupplierNameButtons = document.querySelectorAll('.save-supplier-name-button');

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