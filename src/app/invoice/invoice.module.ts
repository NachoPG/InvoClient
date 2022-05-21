import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { InvoiceRoutingModule } from './invoice-routing.module';
import { InvoiceComponent } from './pages/main-page-invoice/invoice.component';
import { SharedModule } from '../shared/shared.module';
import { InvoiceTableComponent } from './components/invoice-table/invoice-table.component';
import { NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';
import { ButtonModule } from 'primeng/button';
import { SearchFilterPipe } from './pipes/search-filter.pipe';
import { FormsModule } from '@angular/forms';
import { DialogModule } from 'primeng/dialog';
import { InputNumberModule } from 'primeng/inputnumber';
import { ToastModule } from 'primeng/toast';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { SearchFilterDatePipe } from './pipes/search-filter-date.pipe';
import { TooltipModule } from 'primeng/tooltip';

@NgModule({
  declarations: [
    InvoiceComponent,
    InvoiceTableComponent,
    SearchFilterPipe,
    SearchFilterDatePipe,
  ],
  imports: [
    CommonModule,
    InvoiceRoutingModule,
    SharedModule,
    NgbPaginationModule,
    ButtonModule,
    FormsModule,
    DialogModule,
    InputNumberModule,
    ToastModule,
    ConfirmDialogModule,
    TooltipModule,
  ],
})
export class InvoiceModule {}
