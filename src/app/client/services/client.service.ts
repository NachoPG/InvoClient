import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';
import { Clients } from '../interfaces/clients.interface';

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

    return this.http.get<Clients[]>(url, { headers: headers });
  }
}
