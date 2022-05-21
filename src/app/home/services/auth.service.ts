import { Injectable } from '@angular/core';
import { Observable, tap, of } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ResponseAuthLogin } from '../intefaces/responseAuthLogin.interface';
import { JwtHelperService } from '@auth0/angular-jwt';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private apiURL: string = environment.baseURL;
  private _auth: ResponseAuthLogin | undefined;

  get auth() {
    return { ...this._auth };
  }

  constructor(
    private http: HttpClient,
    private jwtHelperService: JwtHelperService
  ) {}

  loginUser(userCredentials: {
    username: '';
    password: '';
  }): Observable<ResponseAuthLogin> {
    const url = `${this.apiURL}/login`;
    return this.http.post<ResponseAuthLogin>(url, userCredentials).pipe(
      tap((authToken) => {
        this._auth = authToken;
        localStorage.setItem('token', authToken.token);
        const dataUser = this.jwtHelperService.decodeToken(
          localStorage.getItem('token')!
        );
        localStorage.setItem('user', JSON.stringify(dataUser.data));
      })
    );
  }

  verifyAuthUser(): boolean {
    const token = localStorage.getItem('token');

    if (
      this.jwtHelperService.isTokenExpired(token!) ||
      !localStorage.getItem('token')
    ) {
      return false;
    }

    return true;
  }
}
