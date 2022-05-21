import { Pipe, PipeTransform } from '@angular/core';
import { Invoice } from '../interfaces/invoice.interface';

@Pipe({
  name: 'searchFilterInvoice',
})
export class SearchFilterPipe implements PipeTransform {
  transform(listInvoices: Invoice[], searchValue: string): Invoice[] {
    if (!listInvoices || !searchValue) {
      return listInvoices;
    }

    return listInvoices.filter(
      (invoice) =>
        invoice.nameArticle.toLowerCase().includes(searchValue.toLowerCase()) ||
        invoice.idInvoice.includes(searchValue)
    );
  }
}
