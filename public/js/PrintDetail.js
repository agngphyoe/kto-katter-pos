
function executeDetailPrint(myContent) {
    const printContents = document.getElementById(myContent).innerHTML;

    var printWindow = window.open("", "_blank");
    printWindow.document.open();
    printWindow.document.write("<html><head><title>Print</title>");
    printWindow.document.write("<style>");
    printWindow.document.write("table { border-collapse: collapse; }");
    printWindow.document.write(
        "th, td { border: 1px solid black; padding: 5px; }"
    );


    printWindow.document.write("</style>");
    printWindow.document.write("</head><body>");
    printWindow.document.write(
        '<div class="table-card px-3 rounded-b" id="myContent">' +
            printContents +
            "</div>"
    );
    printWindow.document.write("</body></html>");
    printWindow.document.close();

    printWindow.print();

    printWindow.close();
}
