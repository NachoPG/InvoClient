import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { ConfirmationService, MessageService } from 'primeng/api';
import { Invoice } from '../../interfaces/invoice.interface';
import { saveAs } from 'file-saver';
import { jsPDF } from 'jspdf';
import 'jspdf-autotable';

@Component({
  selector: 'app-invoice-table',
  templateUrl: './invoice-table.component.html',
  styleUrls: ['./invoice-table.component.css'],
  providers: [MessageService, ConfirmationService],
})
export class InvoiceTableComponent implements OnInit {
  @Input() invoiceData: Invoice[] = [];
  @Input() showErrorCreate: boolean = false;
  @Input() showErrorEdit: boolean = false;
  @Input() showErrorDelete: boolean = false;
  @Input() errorTextUpdate: string = '';
  @Input() errorTextCreate: string = '';
  @Output() onSubmitCreate: EventEmitter<Invoice> = new EventEmitter();
  @Output() onSubmitEdit: EventEmitter<Invoice> = new EventEmitter();
  @Output() onClickDelete: EventEmitter<string> = new EventEmitter();

  page: number = 1;
  pageSize: number = 10;
  searchValue: string = '';
  searchValueDate!: Date;
  display: boolean = false;
  toggleCreate: boolean = false;
  invoiceInfoActive: Invoice = {
    idInvoice: '',
    nameArticle: '',
    price_unit: 0,
    price_total: 0,
    description: '',
    amount: 0,
    order_date: new Date(),
  };
  rows: any[] = [];
  rowsData: any[] = [];
  constructor(
    private messageService: MessageService,
    private confirmationService: ConfirmationService
  ) {}

  ngOnInit(): void {}

  exportPdf() {
    const head = [
      [
        'ID',
        'Article Name',
        'Unit Price',
        'Amount',
        'Total Price',
        'Description',
        'Order Date',
      ],
    ];

    Object.entries(this.invoiceData).forEach(([key, value]) => {
      this.rowsData = [];
      this.rowsData.push(value.idInvoice);
      this.rowsData.push(value.nameArticle);
      this.rowsData.push(value.price_unit);
      this.rowsData.push(value.amount);
      this.rowsData.push(value.price_total);
      this.rowsData.push(value.description);
      this.rowsData.push(value.order_date);
      this.rows.push(this.rowsData);
    });

    const doc = new jsPDF('l', 'pt', 'a4');
    doc.setFontSize(18);
    doc.text(`Invoices Data of ${localStorage.getItem('nameCompany')}`, 11, 27);
    (doc as any).autoTable({
      head: head,
      body: this.rows,
      theme: 'plain',
    });
    doc.output('dataurlnewwindow');
    doc.save('invoicesData.pdf');
  }

  exportExcel() {
    import('xlsx').then((xlsx) => {
      const worksheet = xlsx.utils.json_to_sheet(this.invoiceData);
      const workbook = { Sheets: { data: worksheet }, SheetNames: ['data'] };
      const excelBuffer: any = xlsx.write(workbook, {
        bookType: 'xlsx',
        type: 'array',
      });
      this.saveAsExcelFile(excelBuffer, 'Invoices');
    });
  }

  private saveAsExcelFile(buffer: any, fileName: string): void {
    let EXCEL_TYPE =
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
    let EXCEL_EXTENSION = '.xlsx';
    const data: Blob = new Blob([buffer], {
      type: EXCEL_TYPE,
    });
    saveAs(
      data,
      fileName + '_export_' + new Date().getTime() + EXCEL_EXTENSION
    );
  }

  resetSearch() {
    this.searchValue = '';
  }

  hideDialog() {
    this.display = false;
  }

  showDialogEdit(invoice: Invoice) {
    this.invoiceInfoActive = { ...invoice };
    this.display = true;
    this.toggleCreate = false;
  }

  saveInvoice() {
    if (this.toggleCreate) {
      this.createInvoice();
    } else {
      this.editInvoice();
    }
  }

  showDialogCreate() {
    this.display = true;
    this.toggleCreate = true;
    this.invoiceInfoActive = {} as Invoice;
  }

  private editInvoice() {
    const { price_unit, amount } = this.invoiceInfoActive;
    this.invoiceInfoActive.price_total = price_unit * amount;
    this.onSubmitEdit.emit(this.invoiceInfoActive);
    setTimeout(() => {
      if (!this.showErrorEdit) {
        this.messageService.add({
          severity: 'success',
          summary: 'Update Exito',
          detail: 'Se ha modificado con Exito!',
        });
        this.hideDialog();
      } else {
        this.messageService.add({
          severity: 'error',
          summary: 'Error',
          detail: 'Se ha producido un error. Compruebe los datos introducidos',
        });
      }
    }, 500);
  }

  private createInvoice() {
    const { nameArticle, price_unit, description, amount, order_date } =
      this.invoiceInfoActive;
    if (
      nameArticle !== '' &&
      nameArticle !== undefined &&
      price_unit > 0 &&
      price_unit !== undefined &&
      description !== '' &&
      description !== undefined &&
      amount > 0 &&
      amount !== undefined &&
      order_date !== undefined
    ) {
      this.invoiceInfoActive.price_total = price_unit * amount;
      this.onSubmitCreate.emit(this.invoiceInfoActive);

      setTimeout(() => {
        if (!this.showErrorCreate) {
          this.messageService.add({
            severity: 'success',
            summary: 'Creado con Exito',
            detail: 'Se ha creado con Exito!',
          });
          this.hideDialog();
        } else {
          this.messageService.add({
            severity: 'error',
            summary: 'Error',
            detail:
              'Se ha producido un error con la creacion de la factura. Compruebe los datos introducidos',
          });
        }
      }, 500);
    }
  }

  confirmDelete(id: string) {
    this.confirmationService.confirm({
      message: 'Do you want to delete this invoice?',
      header: 'Delete Confirmation',
      icon: 'pi pi-info-circle',
      accept: () => {
        this.onClickDelete.emit(id);

        setTimeout(() => {
          if (!this.showErrorDelete) {
            this.messageService.add({
              severity: 'success',
              summary: 'Factura Eliminada',
              detail: 'Se ha eliminado correctamente',
            });
          } else {
            this.messageService.add({
              severity: 'error',
              summary: 'Error',
              detail: 'Se ha producido un error',
            });
          }
        }, 500);
      },
    });
  }
}
