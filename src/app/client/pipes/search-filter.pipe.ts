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
        client.Razon_social.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.Provincia.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.Poblacion.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.Cif.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.Pais.toLowerCase().includes(searchValue.toLowerCase()) ||
        client.Id_Cliente.toLowerCase().includes(searchValue.toLowerCase())
    );
  }
}
