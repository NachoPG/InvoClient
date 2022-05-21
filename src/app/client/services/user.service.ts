import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { PasswordChange } from '../interfaces/passwordChange.interface';
import { ResponseAPI } from '../interfaces/responseAPI.inteface';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  private apiURL: string = environment.baseURL;

  constructor(private httpClient: HttpClient) {}

  changePassword(dataPassword: PasswordChange): Observable<ResponseAPI> {
    const url = `${this.apiURL}/changePassword`;
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.httpClient.put<ResponseAPI>(url, dataPassword, { headers });
  }
}
