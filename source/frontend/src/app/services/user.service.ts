import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/index';
import { catchError, tap } from 'rxjs/internal/operators';

import { RpcResponseType } from '../types/rpc-response.type';
import { User } from '../models/users.model';
import { environment } from '../../environments/environment';

@Injectable()
export class UserService {
  private baseUrl: string;

  constructor( private http: HttpClient ) {
    this.baseUrl = environment.apiBase;
  }

  public register( user: User ): Observable<RpcResponseType> {
    return this.http
      .post(this.baseUrl + '/api/register', user)
      .pipe(
        tap( (res: RpcResponseType) => {
          if (res.success) {
            const flash = { ...JSON.parse(localStorage.getItem('flash')), userRegistered: res.message };
            localStorage.setItem('flash', JSON.stringify(flash));
          }
        })
      );
  }
}
