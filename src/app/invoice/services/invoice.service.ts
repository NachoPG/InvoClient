import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ResponseAPI } from 'src/app/client/interfaces/responseAPI.inteface';
import { environment } from 'src/environments/environment';
import { Invoice } from '../interfaces/invoice.interface';

@Injectable({
  providedIn: 'root',
})
export class InvoiceService {
  private apiURL: string = environment.baseURL;

  constructor(private http: HttpClient) {}

  getInvoicesFromClient(id: string): Observable<Invoice[]> {
    const url = `${this.apiURL}/invoices/${id}`;
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.http.get<Invoice[]>(url, { headers });
  }

  createInvoiceFromClient(invoice: Invoice): Observable<ResponseAPI> {
    const url = `${this.apiURL}/insertInvoiceFromClient`;
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.http.post<ResponseAPI>(url, invoice, { headers });
  }

  updateInvoice(invoice: Invoice): Observable<ResponseAPI> {
    const url = `${this.apiURL}/updateInvoice`;
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.http.put<ResponseAPI>(url, invoice, { headers });
  }

  deleteClient(id: string): Observable<ResponseAPI> {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });
    const url = `${this.apiURL}/deleteInvoice/${id}`;
    return this.http.delete<ResponseAPI>(url, { headers });
  }
}
