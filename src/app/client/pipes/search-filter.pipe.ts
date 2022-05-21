import { Pipe, PipeTransform } from '@angular/core';
import { Clients } from '../interfaces/clients.interface';

@Pipe({
  name: 'searchFilter',
})
export class SearchFilterPipe implements PipeTransform {
  transform(listClients: Clients[], searchValue: string): Clients[] {
    if (!listClients || !searchValue) {
      return listClients;
    }

    return listClients.filter(
      (client) =>
        client.nameCompany.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.province.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.population.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.cif.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.country.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.idClient.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.email.toLowerCase().includes(searchValue.toLowerCase())
    );
  }
}
