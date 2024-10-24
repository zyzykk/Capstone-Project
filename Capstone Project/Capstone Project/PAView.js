document.addEventListener('DOMContentLoaded', function() {
    const paymentAdviceDetails = document.getElementById('paymentAdviceDetails');
    
    // Retrieve the payment advice data from localStorage
    const paymentAdviceData = JSON.parse(localStorage.getItem('paymentAdviceData'));

    if (paymentAdviceData) {
        const detailsHTML = `
            <div class="detail-row">
                <span class="detail-label">Payer Name:</span>
                <span>${paymentAdviceData.payerName}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payer Account Number:</span>
                <span>${paymentAdviceData.payerAccount}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount:</span>
                <span>${paymentAdviceData.currency} ${paymentAdviceData.amount}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Date:</span>
                <span>${paymentAdviceData.paymentDate}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Reference Number:</span>
                <span>${paymentAdviceData.referenceNumber}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Description:</span>
                <span>${paymentAdviceData.description || 'N/A'}</span>
            </div>
        `;

        paymentAdviceDetails.innerHTML = detailsHTML;
    } else {
        paymentAdviceDetails.innerHTML = '<p>No payment advice data found.</p>';
    }

    // Clear the localStorage after displaying the data
    localStorage.removeItem('paymentAdviceData');
});