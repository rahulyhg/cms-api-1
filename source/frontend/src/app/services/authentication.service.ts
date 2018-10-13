import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { catchError, tap } from 'rxjs/internal/operators';
import { Observable, of } from 'rxjs/index';

import { AppErrorHandler } from './error-handler';
import { RpcResponseType } from '../types/rpc.response.type';
import { UserCredentialType } from '../types/user.credential.type';

@Injectable()
export class AuthenticationService {
  readonly baseUrl: string = 'http://localhost:8080';
  readonly requestOption = {
    withCredentials: true,
  };

  constructor( private http: HttpClient ) {
  }

  logout() {
    return this.http.get<RpcResponseType>(this.baseUrl + '/api/logout')
      .pipe(
        tap(( res: RpcResponseType ) => {
          if (res.result) {
            localStorage.removeItem('currentUser');
          }
        }),
        catchError(this.handleError('logout'))
      );
  }

  isLoggedIn() {
    return this.http.get<RpcResponseType>(this.baseUrl + '/api/user-guard', this.requestOption)
      .pipe(
        tap(this.resetCurrentUser),
        catchError(this.handleError('isLoggedIn'))
      );
  }

  login( credential: UserCredentialType ) {
    return this.http.post<RpcResponseType>(this.baseUrl + '/api/login', credential, this.requestOption)
      .pipe(
        tap(this.resetCurrentUser),
        catchError(this.handleError('login'))
      );
  }

  private handleError( operation = 'operation', resutl?: AppErrorHandler ) {
    return ( error: HttpErrorResponse ): Observable<AppErrorHandler> => {
      const errMessage = new AppErrorHandler(error);
      return of(errMessage as AppErrorHandler);
    };
  }

  private resetCurrentUser( res: RpcResponseType ) {
    if (res.success) {
      localStorage.setItem('currentUser', JSON.stringify(res.result));
    }
  }
}
