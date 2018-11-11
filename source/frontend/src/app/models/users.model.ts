export class User {
  id: number;
  email: string;
  fullName: string;

  constructor(
    user: { id: 0, email: '', fullName: '' }
  ) {
    this.id = user.id;
    this.email = user.email;
    this.fullName = user.fullName;
  }
}
