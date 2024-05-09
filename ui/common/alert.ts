export interface AppAlertOptions {
  heading?: string;
  message: string;
  type?: 'error' | 'warning' | 'success' | 'info';
  deduplicate?: boolean;
}

export class AppAlert {
  heading: string | null;
  message: string;
  type: string;
  deduplicate: boolean;
  uniq: string;
  constructor(msg: AppAlertOptions) {
    this.heading = msg.heading ?? null;
    this.message = msg.message;
    this.type = msg.type ?? 'info';
    this.deduplicate = msg.deduplicate ?? false;
    this.uniq = new Date().toISOString();
  }
  equals(other: AppAlert): boolean {
    return (
      this.heading === other.heading &&
      this.message === other.message &&
      this.type === other.type &&
      this.deduplicate === other.deduplicate
    );
  }
}
