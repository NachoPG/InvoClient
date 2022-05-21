import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Observable } from 'rxjs';
import { ResponseAPI } from 'src/app/client/interfaces/responseAPI.inteface';
import { environment } from 'src/environments/environment';
import { User } from '../Intefaces/user.interface';
import { UserData } from '../Intefaces/userData.interface';

@Injectable({
  providedIn: 'root',
})
export class AdminService {
  private apiURL: string = environment.baseURL;
  user: UserData = {
    idUser: '',
    name: '',
    surname: '',
    username: '',
    admin: '',
  };

  constructor(
    private http: HttpClient,
    private jwtHelperService: JwtHelperService
  ) {}

  getAllUsers(): Observable<UserData[]> {
    const url = `${this.apiURL}/users/${this.user.idUser}`;
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.http.get<UserData[]>(url, { headers });
  }

  createUser(userData: User): Observable<ResponseAPI> {
    const url = `${this.apiURL}/register/${this.user.idUser}`;
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.http.post<ResponseAPI>(url, userData, { headers });
  }

  deleteUserById(userId: string): Observable<ResponseAPI> {
    const url = `${this.apiURL}/deleteUser/${this.user.idUser}/${userId}`;
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.http.delete<ResponseAPI>(url, { headers });
  }

  verifyAuthAdmin(): boolean {
    const token = localStorage.getItem('token');
    const stringAdmin = localStorage.getItem('admin');
    const isAdmin = stringAdmin === '1' ? true : false;
    this.user = JSON.parse(localStorage.getItem('user')!);

    if (
      this.jwtHelperService.isTokenExpired(token!) ||
      !localStorage.getItem('token') ||
      !isAdmin
    ) {
      return false;
    }

    return true;
  }
}
