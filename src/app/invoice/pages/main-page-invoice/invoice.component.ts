import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { switchMap } from 'rxjs';
import { Invoice } from '../../interfaces/invoice.interface';
import { InvoiceService } from '../../services/invoice.service';

@Component({
  selector: 'app-invoice',
  templateUrl: './invoice.component.html',
  styleUrls: ['./invoice.component.css'],
})
export class InvoiceComponent implements OnInit {
  invoiceData: Invoice[] = [];
  nameCompany: string | null = localStorage.getItem('nameCompany');
  clientIdInvoice!: number;
  errorCreate: boolean = false;
  errorUpdate: boolean = false;
  errorDelete: boolean = false;
  errorTextUpdate: string = '';
  errorTextCreate: string = '';
  constructor(
    private invoiceService: InvoiceService,
    private activatedRoute: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.getInvoicesFromClient();
  }

  getInvoicesFromClient() {
    this.activatedRoute.params
      .pipe(
        switchMap(({ clientId }) => {
          this.clientIdInvoice = clientId;
          return this.invoiceService.getInvoicesFromClient(clientId);
        })
      )
      .subscribe({
        next: (response) => (this.invoiceData = response),
        error: (err) => console.error(err),
      });
  }

  createInvoice(invoice: Invoice) {
    invoice.idClient = this.clientIdInvoice;
    this.invoiceService.createInvoiceFromClient(invoice).subscribe({
      next: () => {
        this.errorCreate = false;
        this.ngOnInit();
      },
      error: (err) => {
        console.log(err);
        this.errorCreate = true;
        this.errorTextCreate = err.error.message;
      },
    });
  }

  updateInvoice(invoice: Invoice) {
    this.invoiceService.updateInvoice(invoice).subscribe({
      next: () => {
        this.errorUpdate = false;
        this.ngOnInit();
      },
      error: (err) => {
        this.errorUpdate = true;
        console.log(err);
        this.errorTextUpdate = err.error.message;
      },
    });
  }

  deleteInvoice(idInvoice: string) {
    this.invoiceService.deleteClient(idInvoice).subscribe({
      next: () => {
        this.ngOnInit();
        this.errorDelete = false;
      },
      error: (err) => {
        this.errorDelete = true;
        console.error(err);
      },
    });
  }
}
