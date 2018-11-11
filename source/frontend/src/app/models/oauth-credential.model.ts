import { environment } from '../../environments/environment';

export class OAuthCredentialType {
  username: string;
  password: string;
  grant_type = 'password';
  client_id = environment.client_id;

  constructor(
    credentials: { username: '', password: '' }
  ) {
    this.username = credentials.username;
    this.password = credentials.password;
  }
}
