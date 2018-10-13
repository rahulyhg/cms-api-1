import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { catchError, tap } from 'rxjs/internal/operators';
import { Observable, of } from 'rxjs/index';

import { AppErrorHandler } from './error-handler';
import { RpcResponseType } from '../types/rpc.response.type';

@Injectable()
export class AuthenticationService {
  readonly baseUrl: string = 'http://localhost:8080/';

  constructor( private http: HttpClient ) {
  }

  logout() {
    return this.http.get<RpcResponseType>(this.baseUrl + 'api/logout')
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
    return this.http.get<RpcResponseType>(this.baseUrl + 'api/check-user', { withCredentials: true })
      .pipe(
        catchError(this.handleError('isLoggedIn'))
      );
  }

  login( email: string, password: string ) {
    const body = {
      email: email,
      password: password
    };
    return this.http.post<any>(this.baseUrl + 'api/login', body, { withCredentials: true })
      .pipe(
        tap(res => {
          if (res.result) {
            localStorage.setItem('currentUser', res.userId);
          }
        }),
        catchError(this.handleError('login'))
      );
  }

  private handleError( operation = 'operation', resutl?: AppErrorHandler ) {
    return ( error: HttpErrorResponse ): Observable<AppErrorHandler> => {
      const errMessage = new AppErrorHandler(error);
      return of(errMessage as AppErrorHandler);
    };
  }
}
