import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/index';

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
    return this.http.post<RpcResponseType>(this.baseUrl + '/api/register', user);
  }
}
