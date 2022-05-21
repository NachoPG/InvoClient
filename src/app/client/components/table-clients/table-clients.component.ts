import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Clients } from '../../interfaces/clients.interface';
import { ConfirmationService } from 'primeng/api';
import { MessageService } from 'primeng/api';
import { jsPDF } from 'jspdf';
import 'jspdf-autotable';

@Component({
  selector: 'app-table-clients',
  templateUrl: './table-clients.component.html',
  styleUrls: ['./table-clients.component.css'],
  providers: [ConfirmationService, MessageService],
})
export class TableClientsComponent implements OnInit {
  @Input() clientsList: Clients[] = [];
  @Output() onClickDelete: EventEmitter<string> = new EventEmitter();
  @Input() showErrorDelete: boolean = false;
  @Output() clientEdit: EventEmitter<Clients> = new EventEmitter();
  @Output() clientCreate: EventEmitter<Clients> = new EventEmitter();
  @Input() errorUpdate: boolean = false;
  @Input() errorCreate: boolean = false;
  @Input() errorTextUpdate: string = '';
  @Input() errorTextCreate: string = '';
  @Output() onClickInvoice: EventEmitter<string> = new EventEmitter();

  display: boolean = false;
  page: number = 1;
  pageSize: number = 10;
  searchValue: string = '';
  clientActive: Clients = {
    idClient: '',
    nameCompany: '',
    direction: '',
    phone: '',
    email: '',
    province: '',
    country: '',
    cif: '',
    population: '',
    codePostal: '',
  };
  titleDialog: string = '';
  toggleCreate: boolean = false;
  rows: any[] = [];
  rowsData: any[] = [];

  constructor(
    private confirmationService: ConfirmationService,
    private messageService: MessageService
  ) {}

  ngOnInit() {}

  confirmDelete(id: string) {
    this.confirmationService.confirm({
      message: '¿Desea eliminar este cliente?',
      header: 'Delete Confirmation',
      icon: 'pi pi-info-circle',
      accept: () => {
        this.onClickDelete.emit(id);
        setTimeout(() => {
          if (!this.showErrorDelete) {
            this.messageService.add({
              severity: 'success',
              summary: 'Cliente Eliminado',
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

  resetSearch() {
    this.searchValue = '';
  }

  showDialogEdit(client: Clients) {
    this.clientActive = { ...client };
    this.display = true;
    this.toggleCreate = false;
    this.titleDialog = 'Clients Details';
  }

  showDialogCreate() {
    this.display = true;
    this.toggleCreate = true;
    this.clientActive = {} as Clients;
    this.titleDialog = 'Client Create';
  }

  saveClient() {
    if (this.toggleCreate) {
      this.addClient();
    } else {
      this.editClient();
    }
  }

  showInvoicesFromClient(id: string, nameCompany: string) {
    this.onClickInvoice.emit(id);
    localStorage.setItem('nameCompany', nameCompany);
  }

  private editClient() {
    this.clientEdit.emit(this.clientActive);
    setTimeout(() => {
      if (!this.errorUpdate) {
        this.messageService.add({
          severity: 'success',
          summary: 'Update Exito',
          detail: 'Se ha modificado el cliente con Exito!',
        });
        this.hideDialog();
        this.clientActive = {} as Clients;
      } else {
        this.messageService.add({
          severity: 'error',
          summary: 'Error',
          detail: this.errorTextUpdate,
        });
      }
    }, 500);
  }

  private addClient() {
    this.clientCreate.emit(this.clientActive);
    setTimeout(() => {
      if (!this.errorCreate) {
        this.messageService.add({
          severity: 'success',
          summary: 'Creado con Exito',
          detail: 'Se ha creado el cliente con Exito!',
        });
        this.hideDialog();
      } else {
        this.messageService.add({
          severity: 'error',
          summary: 'Error',
          detail: this.errorTextCreate,
        });
      }
    }, 500);
  }

  hideDialog() {
    this.display = false;
  }

  exportPdf() {
    const head = [
      [
        'ID',
        'Name Company',
        'Direction',
        'Phone',
        'Email',
        'Province',
        'Country',
        'CIF',
        'Population',
        'Code Postal',
      ],
    ];

    Object.entries(this.clientsList).forEach(([key, value]) => {
      this.rowsData = [];
      this.rowsData.push(value.idClient);
      this.rowsData.push(value.nameCompany);
      this.rowsData.push(value.direction);
      this.rowsData.push(value.phone);
      this.rowsData.push(value.email);
      this.rowsData.push(value.province);
      this.rowsData.push(value.country);
      this.rowsData.push(value.cif);
      this.rowsData.push(value.population);
      this.rowsData.push(value.codePostal);
      this.rows.push(this.rowsData);
    });

    const doc = new jsPDF('l', 'pt', 'a4');
    doc.setFontSize(18);
    doc.text(`Clients List`, 11, 27);
    (doc as any).autoTable({
      head: head,
      body: this.rows,
      theme: 'plain',
    });
    doc.output('dataurlnewwindow');
    doc.save('clientsList.pdf');
  }
}
