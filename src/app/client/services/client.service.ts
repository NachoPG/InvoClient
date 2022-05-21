import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';
import { Clients } from '../interfaces/clients.interface';
import { ResponseAPI } from '../interfaces/responseAPI.inteface';

@Injectable({
  providedIn: 'root',
})
export class ClientService {
  private apiURL: string = environment.baseURL;

  constructor(private http: HttpClient) {}

  getClients(): Observable<Clients[]> {
    const url = `${this.apiURL}/getAllClients`;
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.http.get<Clients[]>(url, { headers });
  }

  deleteClient(id: string): Observable<ResponseAPI> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });
    const url = `${this.apiURL}/deleteClient/${id}`;
    return this.http.delete<ResponseAPI>(url, { headers });
  }

  updateClient(client: Clients): Observable<ResponseAPI> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    const url = `${this.apiURL}/client/${client.idClient}`;
    return this.http.put<ResponseAPI>(url, client, { headers });
  }

  addClient(client: Clients): Observable<ResponseAPI> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });
    const url = `${this.apiURL}/insertNewClient`;
    return this.http.post<ResponseAPI>(url, client, { headers });
  }
}
