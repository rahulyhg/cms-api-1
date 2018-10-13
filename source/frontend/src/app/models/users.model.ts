export class User {
  id: number;
  email: string;
  password: string;
  confirmPassword: string;
  fullname: string;

  constructor() {
    this.id = 0;
    this.fullname = '';
    this.email = '';
    this.confirmPassword = '';
    this.password = '';
  }
}
