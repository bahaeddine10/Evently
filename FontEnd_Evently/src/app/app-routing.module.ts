import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponentComponent } from './login-component/login-component.component';
import { InscriptionComponentComponent } from './inscription-component/inscription-component.component';
import { MyeventsComponent } from './myevents/myevents.component';
import { EventsComponent } from './events/events.component';
import { HomepageComponent } from './homepage/homepage.component';

const routes: Routes = [
  { path: '', redirectTo: '/login', pathMatch: 'full' }, // Redirect to login by default
  { path: 'Homepage', component: HomepageComponent },
  { path: 'login', component: LoginComponentComponent },
  { path: 'inscription', component: InscriptionComponentComponent },
  { path: 'myevents', component: MyeventsComponent },
  { path: 'events', component: EventsComponent }
  // Add more routes as needed
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
