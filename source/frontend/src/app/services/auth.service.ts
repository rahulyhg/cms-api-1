import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/index';

import { RpcResponseType } from '../types/rpc-response.type';
import { OAuthCredentialType } from '../models/oauth-credential.model';
import { environment } from '../../environments/environment';
import { OAuthResponse } from '../types/oauth-response.type';
import { tap } from 'rxjs/internal/operators';

@Injectable()
export class AuthService {
  private baseUrl: string;

  constructor( private http: HttpClient ) {
    this.baseUrl = environment.apiBase;
  }

  get identity() {
    return JSON.parse(localStorage.getItem('user'));
  }

  public logout(): void {
    localStorage.removeItem('user');
  }

  public isLoggedIn(): Observable<RpcResponseType> {
    return this.http
      .get(this.baseUrl + '/api/user-guard')
      .pipe(
        tap(( res: RpcResponseType ) => {
          const user = { ...JSON.parse(localStorage.getItem('user')), details: res.result };
          localStorage.setItem('user', JSON.stringify(user));
        })
      );
  }

  public login( credential: OAuthCredentialType ): Observable<OAuthResponse> {
    return this.http
      .post(this.baseUrl + '/oauth', credential)
      .pipe(
        tap(( res: OAuthResponse ) => {
          localStorage.setItem('user', JSON.stringify({ token: res.access_token }));
        })
      );
  }
}
