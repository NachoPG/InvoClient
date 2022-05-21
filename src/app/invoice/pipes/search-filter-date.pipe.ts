import { Pipe, PipeTransform } from '@angular/core';
import { Invoice } from '../interfaces/invoice.interface';

@Pipe({
  name: 'searchFilterDate',
})
export class SearchFilterDatePipe implements PipeTransform {
  transform(listInvoices: Invoice[], searchValueDate: Date): Invoice[] {
    if (!listInvoices || !searchValueDate) {
      return listInvoices;
    }

    return listInvoices.filter((invoice) =>
      invoice.order_date.toString().includes(searchValueDate.toString())
    );
  }
}
